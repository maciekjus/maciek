<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/uzytkownik/zaloguj", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, AuthorizationCheckerInterface $authChecker): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
/*
        if(true === $authChecker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('pages');
        }

        if(true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }
*/
        //return $this->redirectToRoute('pages');
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/uzytkownik/wyloguj", name="app_logout")
     */
    public function logout(AuthenticationUtils $authenticationUtils): Response
    {
        
    }
}
