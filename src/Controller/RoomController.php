<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
	/**
	 * @Route("/room", name="room")
	 * @IsGranted("ROLE_USER")
	 */
	public function index()
	{
		return $this->render('room/index.html.twig', [
			'words' => ['wq', 'qw'],
			'roomParams' => [
				"id" => 1,
				"name" => "test room",
				"width" => 10,
				"length" => 10,
				"background" => null,
				"desks" => [
					[
						"id" => 1,
						"description" => null,
						"x" => 0,
						"y" => 0,
						"rotation" => null,
						"width" => 0,
						"length" => 0,
						"bookingStart" => "2022-07-12T00:00:00+02:00",
						"bookingEnd" => "2022-07-15T00:00:00+02:00",
						"bookingUser" => 1
					],
					[
						"id" => 2,
						"description" => null,
						"x" => 0,
						"y" => 0,
						"rotation" => null,
						"width" => 0,
						"length" => 0,
						"bookingStart" => null,
						"bookingEnd" => null,
						"bookingUser" => null
					]
				]
			]
		]);
	}
}