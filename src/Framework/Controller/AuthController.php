<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class AuthController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
                 // get the login error if there is one
                 $error = $authenticationUtils->getLastAuthenticationError();
        
                 // last username entered by the user
                 $lastUsername = $authenticationUtils->getLastUsername();
        
                 return $this->render('pages/auth/login.html.twig', [
                     'controller_name' => self::class,
                     'last_username' => $lastUsername,
                     'error'         => $error,
                 ]);
    }    
}
