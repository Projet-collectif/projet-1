<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class AdminHomeController extends AbstractController
{
    /**
     * Function index
     * 
     * @Route("/", name="admin")
     * 
     * @return Response
     */
    public function index(): Response
    {
        return $this->render(
            'admin/matrix/home/index.html.twig', [
                'controller_name' => 'AdminHomeController',
            ]
        );
    }
}
