<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SecurityController extends AbstractController
{
    /**
     * Variable $this->_params
     *
     * @var ParameterBagInterface
     */
    private $_params;

    /**
     * Variable $this->_manager
     *
     * @var EntityManagerInterface
     */
    private $_manager;

    /**
     * Void __construct()
     *
     * @param ParameterBagInterface  $params  Objet
     * @param EntityManagerInterface $manager Objet
     */
    public function __construct(
        ParameterBagInterface $params, 
        EntityManagerInterface $manager
    ) {
        $this->_params = $params;
        $this->_manager = $manager;
    }

    /**
     * Function login
     *
     * @param AuthenticationUtils $authenticationUtils comment
     * 
     * @Route("/login", name="app_login")
     * 
     * @return Response
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
     * Function register
     *
     * @param Request                      $request    comment
     * @param UserPasswordEncoderInterface $encoder    comment
     * @param TranslatorInterface          $translator comment
     * 
     * @Route("/register", name="app_register")
     * 
     * @return Response
     */
    public function register(
        Request $request, 
        UserPasswordEncoderInterface $encoder,
        TranslatorInterface $translator
    ): Response {
        
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        dump($this->_params->get('app_env')); 

        $user = new User();
        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $dateNow = date('Y-m-d H:i:s');
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $activationKey = $dateNow.'|**|'.$user->getEmail();
            $activationKey = password_hash($activationKey, PASSWORD_DEFAULT);
            $activationKey = str_replace("/", "", $activationKey);
            
            $dateNow = \DateTime::createFromFormat('Y-m-d H:i:s', $dateNow);

            // Table User
            if ($this->_params->get('app_env') == "dev") {
                $user->setIsActive(true);
                $user->setActivationKey('');
                $user->setRoles(array('ROLE_ADMIN'));
            } else {
                $user->setIsActive(false);
                $user->setActivationKey($activationKey);
                $user->setRoles(array('ROLE_USER'));
            }
            $user->setPassword($hash);
            $user->setBanned(false);
            $user->setUsercrypt(md5($activationKey));

            // Table Compte
            $user->getCompte()->setDepartement('');
            $user->getCompte()->setCodepostal('');
            $user->getCompte()->setVille('');
            $user->getCompte()->setLat('');
            $user->getCompte()->setLng('');
            $user->getCompte()->setDateRegister($dateNow);
            $user->getCompte()->setLastVisit($dateNow);
            $user->getCompte()->setBannedDate(null);
            $user->getCompte()->setBannedRaison(null);
            $user->getCompte()->setAvatar(null);

            $this->_manager->persist($user);
            $this->_manager->flush();

            // Message flash
            // Notification email envoyé
            $msg = $translator->trans(
                'SUCCESS-REGISTRATION',
                array(),
                'messages',
                $request->getLocale()
            );
            $this->addFlash('success', $msg);

            // Redirection
            return $this->redirectToRoute('app_login');


        }

        return $this->render(
            'security/registration.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Function logout
     * 
     * @Route("/logout", name="app_logout")
     *
     * @return void
     */
    public function logout()
    {
    }
}
