<?php

namespace App\Controller\Admin;

use App\Service\TranslationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/translation")
 */
class AdminTranslationController extends AbstractController
{
    /**
     * @var TranslationService
     */
    private $service;

    public function __construct(ParameterBagInterface $parameterBagInterface)
    {
        $this->service = new TranslationService($parameterBagInterface);
    }

    /**
     * @Route("/", name="admin_translation")
     */
    public function index(Request $request): Response
    {
        $locale = $request->query->get('locale');
        $locales = $this->service->getDefinedTranslations();

        if(in_array($locale, array_keys($locales))) {
            dd($locale);
        } else {
            return $this->render('admin/translation/index.html.twig', [
                'locales' => $locales
            ]);
        }
    }
}
