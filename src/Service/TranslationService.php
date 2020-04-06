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
        if (!in_array($locale, $this->_params->localeCodes())) {
            return false;
        }

        $filename = $this->appRoot() . str_replace('xx', $locale, $this->_params::__FILE_TRANSLATIONS);
        $newMessage = Yaml::dump($data);
        $oldMessages = '';

        if (file_exists($filename)) {
            $oldMessages = file_get_contents($filename);
            $oldFilename = $this->appRoot() . str_replace('xx', $locale, $this->_params::__FILE_TRANSLATIONS_OLD);
            file_put_contents($oldFilename, $oldMessages);
        }

        file_put_contents($filename, $newMessage);

        return true;
    }

    /**
     * Modifie la langue de ref pour la traduction
     * 
     * @param string  $locale
     * @return void
     */
    public function getTranslationRefLocale(): string
    {
        $filename = $this->appRoot() . $this->_params::__FILE_CONFIG;
        return Yaml::parseFile($filename)['settings']['translation']['ref_locale'];
    }

    /**
     * Modifie la langue de ref pour la traduction
     * 
     * @param string  $locale
     * @return void
     */
    public function setTranslationRefLocale(string $locale): void
    {
        if (!in_array($locale, $this->_params->localeCodes()) && $locale != '%locale%') {
            throw new \Exception("Cette langue est introuvable");
        }

        $filename = $this->appRoot() . $this->_params::__FILE_CONFIG;
        $oldFilename = $this->appRoot() . $this->_params::__FILE_CONFIG_OLD;
        file_put_contents($oldFilename, file_get_contents($filename));
        
        $data = Yaml::parseFile($filename);

        $data['settings']['translation']['ref_locale'] = $locale;

        file_put_contents($filename, Yaml::dump($data));
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
     * Retorune le chemin du dossier root
     * 
     * @return string
     */
    private function appRoot(): string
    {
        return $this->_params->get('app_root');
    }
}