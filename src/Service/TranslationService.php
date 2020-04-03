<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Intl\Languages;

class TranslationService
{
    /**
     * @var ParameterBagInterface
     */
    private $_param;

    public function __construct(ParameterBagInterface $parameterBagInterface)
    {
        $this->_param = $parameterBagInterface;
    }

    /**
     * Retourne la liste des locales de traduction dans services.yaml
     * 
     * @return string[]
     */
    public function getDefinedTranslations(): array
    {
        $locales = [];
        $codes = explode('|', $this->_param->get('app_locales'));

        foreach ($codes as $code) {
            $locales[$code] = ucfirst(Languages::getName($code, $code));
        }

        return  $locales;
    }

    /**
     * Retourne la liste des locales de traduction dans services.yaml
     * 
     * @return string[]
     */
    public function getTranslation(): array
    {
        $codes = explode('|', $this->_param->get('appRoot') . '/translations');
        $locales = [];

        foreach ($codes as $code) {
            $locales[$code] = Languages::getName($code, $code);
        }

        return  $locales;
    }
}
