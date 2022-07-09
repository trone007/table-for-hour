<?php

namespace App\Service;

use App\Entity\BookingLog;

interface Booking
{
	public function getDesksByRoomAndDate(int $roomId, \DateTime $dateStart, ?\DateTime $dateEnd = null): array;
	public function bookDesk($deskId, \DateTime $dateStart, ?\DateTime $dateEnd = null): ?BookingLog;
	public function removeDeskBooking($bookingId): void;
}