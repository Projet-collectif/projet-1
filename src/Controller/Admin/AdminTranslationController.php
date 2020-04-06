<?php

namespace App\Controller\Admin;

use App\Service\ParamsService;
use App\Service\TranslationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/translation")
 */
class AdminTranslationController extends AbstractController
{
    /**
     * @var TranslationService
     */
    private $service;

    public function __construct(ParamsService $params)
    {
        $this->service = new TranslationService($params);
    }

    /**
     * @Route("/", name="admin_translation")
     */
    public function index(Request $request, ParamsService $params): Response
    {
        $localeCode = $request->query->get('locale');

        if (in_array($localeCode, array_keys($params->locales()))) {
            $data = $params->getFileTranslation($localeCode);
            $locale = [
                'code' => $localeCode,
                'name' => $this->service->getLocaleName($localeCode)
            ];

            return $this->render(
                'admin/'.$params->getTemplateBack().'/translation/show.html.twig', [
                    'data'      => $data,
                    'locale'    => $locale
                ]
            );
        } else {
            return $this->render(
                'admin/'.$params->getTemplateBack().'/translation/index.html.twig', [
                    'locales' => $params->locales()
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