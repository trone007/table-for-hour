<?php

namespace App\Service;

use App\Entity\BookingLog;
use App\Entity\Desk;
use App\Entity\Room;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;

class BookingImpl implements Booking
{
	private EntityManager $entityManager;

	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function getDesksByRoomAndDate(string $roomId, \DateTime $dateStart, ?\DateTime $dateEnd = null): array
	{
		$room = $this->entityManager->getRepository(Room::class)->find($roomId);
		return $this
			->entityManager
			->getRepository(Desk::class)
			->createQueryBuilder('d')
			->select('d')
			->leftJoin('d.bookingLogs',
				'b',
				Join::WITH,
				'b.dateStart <= :dateStart AND (b.dateEnd IS NULL OR b.dateEnd >= :dateStart)')
			->where('d.room = :room')
			->setParameter('room', $room)
			->setParameter('dateStart', $dateStart)
			->getQuery()
			->getResult();
	}
}