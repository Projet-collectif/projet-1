<?php

namespace App\Helper;

use App\Service\ParamsService;

trait TemplateBackTrait
{
    protected $templateBack;

    /**
     * Void __construct()
     *
     * @param ParamsService $params comment
     */
    public function __construct(ParamsService $params)
    {
        $this->templateBack = $params->getTemplateBack();
    }

}