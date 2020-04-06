<?php

namespace App\Service;

use Symfony\Component\Intl\Languages;
use Symfony\Component\Yaml\Yaml;

class TranslationService
{
    /**
     * Variable 
     * 
     * @var ParamsService
     */
    private $_params;

    /**
     * Void __construct()
     *
     * @param ParamsService $paramsService comment
     */
    public function __construct(ParamsService $paramsService)
    {
        $this->_params = $paramsService;
    }

    /**
     * Met à jour un fichier de traduction (le crée s'il n'existe pas)
     * 
     * @param string $locale Le code de la langue
     * @param array  $data   Le tableau content les messages
     * 
     * @return bool: True en cas de succes, false sinon
     */
    public function updateTranslation(string $locale, array $data): bool
    {
        $locales = explode('|', $this->_params->get('app_locales'));
        if (!in_array($locale, $locales)) {
            return false;
        }

        $filename = $this->getTranslationFilename($locale);
        $newMessage = Yaml::dump($data);
        $oldMessages = '';

        if (file_exists($filename)) {
            $oldMessages = file_get_contents($filename);
            file_put_contents($this->getOldTranslationFilename($locale), $oldMessages);
        }

        file_put_contents($filename, $newMessage);

        return true;
    }

    /**
     * Return le langue correspondate à un code
     * 
     * @param string $code Le code de la langue
     * 
     * @return string La langue correspondante
     */
    public function getLocaleName(string $code): string
    {
        return ucfirst(Languages::getName($code, $code));
    }

    /**
     * Retourne le nom du fichier de traduction à partir de sa langue
     * 
     * @param string $locale La langue
     * 
     * @return string
     */
    private function getTranslationFilename(string $locale): string
    {
        return $this->_params->get('app_root') . str_replace('xx', $locale, $this->_params::__FILE_TRANSLATIONS);
    }

    /**
     * Retourne le nom le l'ancien fichier de traduction à partir de sa langue
     * 
     * @param string $locale La langue
     * 
     * @return string
     */
    private function getOldTranslationFilename(string $locale): string
    {
        return $this->_params->get('app_root') . str_replace('xx', $locale, $this->_params::__FILE_TRANSLATIONS_OLD);
    }
}