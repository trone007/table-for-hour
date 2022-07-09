<?php

namespace App\Service;

interface Booking
{
	public function getDesksByRoomAndDate(int $roomId, \DateTime $dateStart, ?\DateTime $dateEnd = null): array;
}