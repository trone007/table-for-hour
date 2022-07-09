<?php

namespace App\Service;

use App\Entity\BookingLog;
use App\Entity\Desk;
use App\Entity\Room;
use App\Entity\User;
use Doctrine\ORM;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Security\Core\Security;

class BookingImpl implements Booking
{
	private Orm\EntityManagerInterface $entityManager;
	private Security $security;

	public function __construct(Orm\EntityManagerInterface $entityManager, Security $security)
	{
		$this->entityManager = $entityManager;
		$this->security = $security;
	}

	public function getDesksByRoomAndDate(int $roomId, \DateTime $dateStart, ?\DateTime $dateEnd = null): array
	{
		/** @var Room $room */
		$room = $this->entityManager->getRepository(Room::class)->find($roomId);
		if (!$room)
		{
			throw new ORM\EntityNotFoundException("Room is not found");
		}

		$desks = $this
			->entityManager
			->getRepository(Desk::class)
			->createQueryBuilder('d')
			->select('d.id', 'd.description', 'd.x', 'd.y', 'd.rotation', 'd.width', 'd.length', 'b.dateStart bookingStart', 'b.dateEnd bookingEnd', 'u.id bookingUser', 'u.first_name bookingUserName')
			->leftJoin('d.bookingLogs',
				'b',
				Join::WITH,
				'b.dateStart <= :dateStart AND (b.dateEnd IS NULL OR b.dateEnd >= :dateStart)')
			->leftJoin('b.user', 'u')
			->where('d.room = :room')
			->setParameter('room', $room)
			->setParameter('dateStart', $dateStart)
			->getQuery()
			->getResult();

		return [
			'id' => $room->getId(),
			'name' => $room->getName(),
			'width' => $room->getWidth(),
			'length' => $room->getLength(),
			'background' => $room->getBackground(),
			'desks' => $desks
		];
	}

	public function bookDesk(\Symfony\Component\Security\Core\User\UserInterface $user, int $deskId, \DateTime $dateStart, ?\DateTime $dateEnd = null): ?BookingLog
	{
		$desk = $this->entityManager->getRepository(Desk::class)->find($deskId);

		if (!$this->canBookDesk($desk, $dateStart, $dateEnd))
		{
			return null;
		}

//		$user = $this->entityManager->getRepository(User::class)->find($userId);
		$bookingLog = (new BookingLog())
			->setDesk($desk)
			->setDateStart($dateStart)
			->setDateEnd($dateEnd)
			->setUser($user);

		$this->entityManager->persist($bookingLog);
		$this->entityManager->flush();

		return $bookingLog;
	}

	public function removeDeskBooking($bookingId): void
	{
		$bookingLog = $this->entityManager->getRepository(BookingLog::class)->find($bookingId);

		if ($bookingLog)
		{
			$this->entityManager->remove($bookingLog);
			$this->entityManager->flush();
		}
	}

	public function canBookDesk(Desk $desk, \DateTime $dateStart, ?\DateTime $dateEnd = null): bool
	{
		if (!$this->security->getUser())
		{
			return false;
		}

		$bookings  = $this
			->entityManager
			->getRepository(Desk::class)
			->createQueryBuilder('d')
			->select('d.id', 'd.description', 'd.x', 'd.y', 'd.rotation', 'd.width', 'd.length', 'b.dateStart bookingStart', 'b.dateEnd bookingEnd', 'u.id bookingUser')
			->leftJoin('d.bookingLogs',
				'b',
				Join::WITH,
				'b.dateStart <= :dateStart AND (b.dateEnd IS NULL OR b.dateEnd >= :dateStart)')
			->leftJoin('b.user', 'u')
			->where('d = :desk')
			->setParameter('desk', $desk)
			->setParameter('dateStart', $dateStart)
			->getQuery()
			->getResult();


		$canBook = true;
		foreach ($bookings as $booking)
		{
			if ($booking['bookingStart'] != null)
			{
				$canBook = false;
			}
		}

		return $canBook;
	}

	public function completeBooking(BookingLog $bookingLog, \DateTime $dateEnd): BookingLog
	{
		$bookingLog->setDateEnd($dateEnd);
		$bookingLog->setDateStart($dateEnd);
		$this->entityManager->persist($bookingLog);
		$this->entityManager->flush();

		return $bookingLog;
	}

	public function completeAllDeskBookings(Desk $desk): void
	{
		$bookings = $this
			->entityManager
			->getRepository(BookingLog::class)
			->createQueryBuilder('b')
			->select('b')
			->where('b.desk = :desk')
//			->andWhere('b.dateEnd >= :date')
			->setParameter('desk', $desk)
//			->setParameter('date', new \DateTime())
			->getQuery()
			->getResult();

		foreach ($bookings as $booking)
		{
			$this->completeBooking($booking, (new \DateTime())->modify('-1 day'));
		}
	}
}