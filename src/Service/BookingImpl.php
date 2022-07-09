<?php

namespace App\Service;

use App\Entity\Desk;
use App\Entity\Room;
use Doctrine\ORM;
use Doctrine\ORM\Query\Expr\Join;

class BookingImpl implements Booking
{
	private Orm\EntityManagerInterface $entityManager;

	public function __construct(Orm\EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
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
			->select('d.id', 'd.description', 'd.x', 'd.y', 'd.rotation', 'd.width', 'd.length', 'b.dateStart bookingStart', 'b.dateEnd bookingEnd', 'u.id bookingUser')
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
}