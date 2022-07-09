<?php

namespace App\Service;

interface Booking
{
	public function getDesksByRoomAndDate(string $roomId, \DateTime $dateStart, ?\DateTime $dateEnd = null): array;
}