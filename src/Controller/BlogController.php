<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * Index 
     * 
     * @param BlogRepository $blogRepository comment
     * @param integer        $page           comment
     * 
     * @Route("/page/{page}", name="blog_index", methods={"GET"})
     * 
     * @return Response
     */
    public function index(BlogRepository $blogRepository, int $page = 1): Response
    {
        return $this->render(
            'blog/index.html.twig', [
                'blogs' => $blogRepository->findAll(),
            ]
        );
    }
}
