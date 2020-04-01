<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig', [
                'last_username' => $lastUsername, 
                'error' => $error
            ]
        );
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request, 
        UserPasswordEncoderInterface $encoder,
        TranslatorInterface $translator
    ): Response {
        
        $user = new User();
        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
        }

        return $this->render(
            'security/registration.html.twig', [
                'form' => $form->createView()
            ]
        );
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
    }
}
