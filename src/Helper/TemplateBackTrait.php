<?php

namespace App\Helper;

use App\Service\ParamsService;

/**
 * Undocumented trait
 */
trait TemplateBackTrait
{
    protected $templateBack;

    /**
     * Undocumented function
     *
     * @param ParamsService $params comment
     * 
     * @return void
     */
    public function setTemplateBack(ParamsService $params): void 
    {
        $this->templateBack = $params->getTemplateBack();
    }
}