<?php

namespace App\Controller;


use App\Entity\User;
use App\Security\SecurityAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;

class SecurityController extends AbstractController
{

	public function __construct(private FormLoginAuthenticator $authenticator)
	{
	}

	#[Route('/login', name: 'app_login')]
	public function index(EntityManagerInterface $entityManager,
		UserAuthenticatorInterface $authenticatorManager,
		Request $request,
		AuthenticationUtils $authenticationUtils): Response
	{
		$error = $authenticationUtils->getLastAuthenticationError();
		$lastUsername = $authenticationUtils->getLastUsername();

		if ($error) {
			$user = new User();
			$user->setLogin($lastUsername);
			$user->setFirstName($lastUsername);
			$user->setLastName($lastUsername);
			$entityManager->persist($user);
			$entityManager->flush();

			$authenticatorManager->authenticateUser(
				$user,
				$this->authenticator,
				$request
			);

			return $this->redirect('/');
		}
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