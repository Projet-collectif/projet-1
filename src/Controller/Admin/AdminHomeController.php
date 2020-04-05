<?php

/**
 * PHP version 7
 *
 * @category App\Controller\Admin
 * @package  AdminHomeController.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

namespace App\Controller\Admin;

/**
 * PHP version 7
 *
 * @category App\Controller\Admin
 * @package  AdminHomeController.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

use App\Service\ParamsService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * PHP version 7
 *
 * @category App\Controller\Admin
 * @package  AdminHomeController.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 * 
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
    public function index(ParamsService $params): Response
    {
        return $this->render(
            'admin/'.$params->getTemplateBack().'/home/index.html.twig', [
                'controller_name' => 'AdminHomeController',
            ]
        );
    }
}
