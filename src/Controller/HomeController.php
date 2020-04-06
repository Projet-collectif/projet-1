<?php

namespace App\Controller;

use App\Service\ParamsService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ParamsService $params)
    {
        /*
        return $this->render(
            $params->getTemplateFront().'/home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]
        );
        */

        return $this->render(
            'home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]
        );
    }
}
