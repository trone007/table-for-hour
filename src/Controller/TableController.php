<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TableController extends AbstractController
{
	/**
	 * @Route("/table/{id}", name="table")
	 */
	public function index($id)
	{
		return $this->render('table/index.html.twig', [
			'id' => $id
		]);
	}
}