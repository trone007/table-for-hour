<?php

namespace App\Controller;

use App\Entity\BookingLog;
use App\Service\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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

	/**
	 * @Route ("/api/booking/book", name="booking_book_desk", methods={"POST"})
	 */
	public function bookDesk(Request $request, Security $security): JsonResponse
	{
		$deskId = $request->request->getInt('deskId');
		$dateStart = $request->request->get('dateStart');
		$dateEnd = $request->request->get('dateEnd');

		if ($security->getUser() === null) {
			return $this->json(['error' => 'You are not logged in']);
		}

		if ($dateStart)
		{
			$dateStart = new \DateTime($dateStart);
		}
		if ($dateEnd)
		{
			$dateEnd = new \DateTime($dateEnd);
		}
		$booking = $this->bookingService->bookDesk($security->getUser(), $deskId, $dateStart, $dateEnd);

		return $this->json($booking);
	}

	/**
	 * @Route ("/api/booking/{bookingLog}/complete", name="booking_complete_desk", methods={"POST"})
	 */
	public function completeBooking(Request $request, BookingLog $bookingLog): JsonResponse
	{
		$dateEnd = $request->request->get('dateEnd');

		if ($dateEnd)
		{
			$dateEnd = new \DateTime($dateEnd);
		}
		return $this->json($this->bookingService->completeBooking($bookingLog, $dateEnd));
	}
}