<?php

namespace App\Controller;

use App\Entity\BookingLog;
use App\Entity\Desk;
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
		$content = json_decode($request->getContent(), true);
		$deskId = $content['deskId'];
		$dateStart = $content['dateStart'];
		$dateEnd = $content['dateEnd'];

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
	public function completeBooking(Request $request, BookingLog $bookingLog, Security $security): JsonResponse
	{
		$dateEnd = $request->request->get('dateEnd');
		$secUser = $security->getUser();
		if (!$secUser) {
			return $this->json(['error' => 'You are not logged in']);
		}
		if (
			$security->getUser()->getId() != $bookingLog->getUser()->getId()
			&& !$security->isGranted('ROLE_ADMIN')
		) {
			return $this->json(['error' => 'You are not authorized to perform the operation']);
		}

		$dateEnd = $dateEnd ? new \DateTime($dateEnd) : new \DateTime();

		return $this->json($this->bookingService->completeBooking($bookingLog, $dateEnd));
	}

	/**
	 * @Route ("/api/booking/desk/{desk}/complete", name="booking_complete_desk", methods={"POST"})
	 */
	public function completeDeskBooking(Request $request, Desk $desk, Security $security): JsonResponse
	{
		$dateEnd = $request->request->get('dateEnd');
		$secUser = $security->getUser();
		if (!$secUser) {
			return $this->json(['error' => 'You are not logged in']);
		}
		if (
			!$security->isGranted('ROLE_USER')
		) {
			return $this->json(['error' => 'You are not authorized to perform the operation']);
		}

		$this->bookingService->completeAllDeskBookings($desk);
		return $this->json(['success' => true]);
	}

	/**
	 * @Route ("/api/booking/{desk}/can-book/{dateStart}", name="can_book_desk", methods={"GET"})
	 */
	public function canBookDesk(Desk $desk, \DateTime $dateStart, ?\DateTime $dateEnd = null): JsonResponse
	{
		return $this->json(['canBook' => $this->bookingService->canBookDesk($desk, $dateStart, $dateEnd)]);
	}
}