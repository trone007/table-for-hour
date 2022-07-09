<?php

namespace App\Controller;

use App\Service\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
	private Booking $bookingService;

	public function __construct(Booking $bookingService)
	{
		$this->bookingService = $bookingService;
	}
	/**
	 * @Route ("/api/booking/{roomId}/{dateStart}", name="booking_get_desks", methods={"GET"})
	 */
	public function getDesksByRoomAndDate(int $roomId, \DateTime $dateStart, ?\DateTime $dateEnd = null): JsonResponse
	{
		$desks = $this->bookingService->getDesksByRoomAndDate($roomId, $dateStart, $dateEnd);

		return $this->json($desks);
	}
}