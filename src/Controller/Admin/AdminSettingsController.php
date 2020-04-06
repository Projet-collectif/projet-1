<?php

namespace App\Controller\Admin;

use App\Service\ParamsService;
use App\Service\TranslationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * PHP version 7
 * Controller that manage adminstration settings
 * 
 * @category App\Controller\Admin
 * @package  AdminSettingsController.php
 * @author   rand0mdev <bechiirr71@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 * 
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/settings")
 */
class AdminSettingsController extends AbstractController
{
    /**
     * @var ParamsService
     */
    private $params;

    /**
     * @var TranslationService
     */
    private $service;

    /**
     * Constructor
     * 
     * @param ParamsService
     */
    public function __construct(ParamsService $params)
    {
        $this->params = $params;
        $this->service = new TranslationService($params);
    }

    /**
     * Translation settings
     * 
     * @Route("/translation", name="admin_settings_translation")
     * 
     * @param Request
     * @return Response
     */
    public function translation(Request $request): Response
    {
        if($request->isMethod(Request::METHOD_POST)) {
            $translationRef = $request->request->get('translation')['ref_locale'];
            try {
                $this->service->setTranslationRefLocale($translationRef);
                $this->addFlash('success', "Modifications effectuées.");

                return $this->redirectToRoute('admin_settings_translation');
            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());
            }
        }

        return $this->renderBack('translation', [
            'locales' => $this->params->locales(),
            'refLocale' => $this->service->getTranslationRefLocale()
        ]);
    }

    /**
     * Shortcut of render
     * 
     * @param string $view
     * @param array  $parameters
     * @return Response
     */
    private function renderBack(string $view, array $parameters = []): Response
    {
        return $this->render(
            'admin/' . $this->params->getTemplateBack() . '/settings/' . $view . '.html.twig',
            $parameters
        );
    }
}