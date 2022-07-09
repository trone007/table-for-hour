<?php

namespace App\Service;

use App\Entity\BookingLog;

interface Booking
{
	public function getDesksByRoomAndDate(int $roomId, \DateTime $dateStart, ?\DateTime $dateEnd = null): array;
	public function completeBooking(BookingLog $bookingLog, \DateTime $dateEnd): BookingLog;
	public function bookDesk(\Symfony\Component\Security\Core\User\UserInterface $userId, int $deskId, \DateTime $dateStart, ?\DateTime $dateEnd = null): ?BookingLog;
	public function removeDeskBooking($bookingId): void;
}