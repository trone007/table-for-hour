<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
	#[Route('/login', name: 'app_login')]
	public function index(AuthenticationUtils $authenticationUtils): Response
	{
		$error = $authenticationUtils->getLastAuthenticationError();
		$lastUsername = $authenticationUtils->getLastUsername();
		return $this->render('login/index.html.twig', [
			'last_username' => $lastUsername,
			'error' => $error,
		]);
	}

//	#[Route('/login', name: 'app_login_check')]
//	public function check(EntityManagerInterface $entityManager, Request $request, AuthenticationUtils $authenticationUtils): Response
//	{
//		$request->request->get('_username');
//
//		$user = $entityManager->getRepository('App:User')->findOneBy(['login' => $request->request->get('_username')]);
//		if (!$user)
//		{
//			$user
//		}
//		$error = $authenticationUtils->getLastAuthenticationError();
//		$lastUsername = $authenticationUtils->getLastUsername();
//		return $this->render('login/index.html.twig', [
//			'last_username' => $lastUsername,
//			'error' => $error,
//		]);
//	}

	#[Route('/logout', name: 'app_logout')]
	public function logout(): Response
	{
		return $this->redirect('/login');
	}
}