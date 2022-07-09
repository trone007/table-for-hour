<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController

{
	/**
	 * @Route("/", name="index_page")
	 * @IsGranted("ROLE_USER")
	 */
	public function index(): Response
	{
		return $this->render('main/index.html.twig', [
		]);
	}
}