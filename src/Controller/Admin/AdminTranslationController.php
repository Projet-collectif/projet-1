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
        $localeCode = $request->query->get('locale');
        $locales = $this->service->getDefinedTranslations();

        if (in_array($localeCode, array_keys($locales))) {
            $data = $this->service->getTranslation($localeCode);
            $locale = [
                'code' => $localeCode,
                'name' => $this->service->getLocaleName($localeCode)
            ];

            return $this->render(
                'admin/matrix/translation/show.html.twig', [
                    'data'      => $data,
                    'locale'    => $locale
                ]
            );
        } else {
            return $this->render(
                'admin/matrix/translation/index.html.twig', [
                    'locales' => $locales
                ]
            );
        }
    }

    /**
     * @Route("/edit", name="admin_translation_edit", methods={"POST"})
     */
    public function editTranslation(Request $request)
    {
        $query = $request->request->get('translation');

        $locale = $query['locale'];
        $data = array_combine($query['key'], $query['value']);
        
        if ($this->service->updateTranslation($locale, $data)) {
            $this->addFlash('success', 'Le fichier a été mis à jour.');
        } else {
            $this->addFlash('danger', 'Erreur // TODO.');
        }
        
        return $this->redirectToRoute(
            'admin_translation', [
                'locale' => $query['locale']
            ]
        );
    }
}