<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class IndexController extends AbstractController

{
	/**
	 * @Route("/", name="index_page")
	 */
	public function index(Security $security): Response
	{
		if ($security->isGranted('ROLE_USER'))
		{
			return $this->redirectToRoute('room');
		}
		else
		{
			return $this->redirectToRoute('app_login');
		}
	}
}