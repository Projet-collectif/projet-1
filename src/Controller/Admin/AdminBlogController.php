<?php

/**
 * PHP version 7
 *
 * @category App\Controller\Admin
 * @package  AdminBlogController.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

namespace App\Controller\Admin;

/**
 * PHP version 7
 *
 * @category App\Controller\Admin
 * @package  AdminBlogController.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

use App\Entity\Blog;
use App\Form\BlogType;
use App\Helper\FormTextTrait;
use App\Service\ParamsService;
use App\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * PHP version 7
 *
 * @category App\Controller\Admin
 * @package  AdminBlogController.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 * 
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/blog")
 */
class AdminBlogController extends AbstractController
{
    use FormTextTrait;

    /**
     * Variable $this->_params
     *
     * @var ParamsService
     */
    private $_params;

    /**
     * Void __construct()
     * 
     * @param ParamsService $params comment
     */
    public function __construct(ParamsService $params)
    {
        $this->_params = $params;
    }

    /**
     * Index blog
     * 
     * @param BlogRepository $blogRepository comment
     * 
     * @Route("/", name="admin_blog_index", methods={"GET"})
     * 
     * @return Response
     */
    public function index(BlogRepository $blogRepository): Response
    {
        return $this->render(
            'admin/'.$this->_params->getTemplateBack().'/blog/index.html.twig', [
                'controller_name' => 'blog',
                'blogs' => $blogRepository->findAll(),
            ]
        );
    }

    /**
     * New blog
     * 
     * @param Request $request comment
     * 
     * @Route("/new", name="admin_blog_new", methods={"GET","POST"})
     * 
     * @return Response
     */
    public function new(Request $request): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Slug
            $slug = $this->enleveAccents($blog->getTitle());
            $slug = $this->slug($slug);
            $slug = strtolower($slug);
            $blog->setSlug($slug);

            // Hits
            $blog->setHits(0);
            
            // Created
            $dateNow = date('Y-m-d H:i:s');
            $dateNow = \DateTime::createFromFormat('Y-m-d H:i:s', $dateNow);
            $blog->setCreated($dateNow);

            // Manager
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('admin_blog_index');
        }

        return $this->render(
            'admin/'.$this->_params->getTemplateBack().'/blog/new.html.twig', [
                'blog' => $blog,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Show blog
     * 
     * @param Blog $blog comment
     * 
     * @Route("/{id}", name="admin_blog_show", methods={"GET"})
     * 
     * @return Response
     */
    public function show(Blog $blog): Response
    {
        return $this->render(
            'admin/'.$this->_params->getTemplateBack().'/blog/show.html.twig', [
                'blog' => $blog,
            ]
        );
    }

    /**
     * Edit blog
     * 
     * @param Request $request comment
     * @param Blog    $blog    comment
     * 
     * @Route("/edit/{id}", name="admin_blog_edit", methods={"GET","POST"})
     * 
     * @return Response
     */
    public function edit(Request $request, Blog $blog): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Slug
            $slug = $this->enleveAccents($blog->getTitle());
            $slug = $this->slug($slug);
            $slug = strtolower($slug);
            $blog->setSlug($slug);

            // Manager
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('admin_blog_index');
        }

        return $this->render(
            'admin/'.$this->_params->getTemplateBack().'/blog/edit.html.twig', [
                'blog' => $blog,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete blog
     * 
     * @param Request $request comment
     * @param Blog    $blog    comment
     * 
     * @Route("/delete/{id}", name="admin_blog_delete", methods={"DELETE"})
     * 
     * @return Response
     */
    public function delete(Request $request, Blog $blog): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($blog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_blog_index');
    }

    /**
     * Ajax
     * 
     * @param Request        $request        comment
     * @param BlogRepository $blogRepository comment
     * 
     * @Route("/publish/ajax", name="admin_blog_ajax", methods={"POST"})
     * 
     * @return Response
     */
    public function ajax(Request $request, BlogRepository $blogRepository): Response 
    {
        $return = false;
        $blog = $blogRepository->find($request->request->get('id'));
        $action = $request->request->get('action');

        if (!empty($blog) && !empty($action)) {
            if ($action == "true") {
                $blog->setPublish(true);
            }
            if ($action == "false") {
                $blog->setPublish(false);
            }

            // Manager
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blog);
            $entityManager->flush();

            $return = true;
        } 

        // RESPONSE
        $response = new Response(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');
    
        return $response;
    }

}
