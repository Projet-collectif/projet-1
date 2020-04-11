<?php

/**
 * PHP version 7
 *
 * @category App\Controller
 * @package  BlogController.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

namespace App\Controller;

/**
 * PHP version 7
 *
 * @category App\Controller
 * @package  BlogController.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

use App\Service\ParamsService;
use App\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * PHP version 7
 *
 * @category App\Controller
 * @package  BlogController.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 * 
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * Variable $this->_blogRepo
     *
     * @var BlogRepository
     */
    private $_blogRepo;

    /**
     * Variable $this->_listLimit
     *
     * @var ParamsService
     */
    private $_listLimit;

    /**
     * Void __construct()
     *
     * @param BlogRepository $blogRepository comment
     * @param ParamsService  $params         comment
     */
    public function __construct(
        BlogRepository $blogRepository, 
        ParamsService $params
    ) {
        $this->_blogRepo = $blogRepository;
        $this->_listLimit = $params->config()['site']['listLimit'];
    }

    /**
     * Index 
     * 
     * @param integer $page comment
     * 
     * @Route("/page/{page}", name="blog_index", methods={"GET"})
     * 
     * @return Response
     */
    public function index(int $page = 1): Response
    {
        $total = $this->_blogRepo->findByTotalAll();
        $blogs = $this->_blogRepo->findByAll($page);

        // Création de la pagination
        $pagination = array(
            'page' => $page,
            'nbPages' => ceil($total['total']/$this->_listLimit),
            'nomRoute' => 'blog_index',
            'paramsRoute' => array()
        );

        return $this->render(
            'blog/index.html.twig', [
                'blogs' => $blogs,
                'total_blogs' => $total['total'],
                'pagination' => $pagination,
            ]
        );
    }

    /**
     * View
     * 
     * @param string $slug comment
     * 
     * @Route("/view/{slug}", name="blog_view")
     *
     * @return Response
     */
    public function view(string $slug): Response
    {
        return $this->render(
            'blog/view.html.twig', [
                'controller_name' => 'BlogController',
                'blog' => $this->_blogRepo->findBySlug($slug),
            ]
        );
    }

}
