<?php

/**
 * PHP version 7
 *
 * @category App\Service
 * @package  ParamsService.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

namespace App\Service;

/**
 * PHP version 7
 *
 * @category App\Service
 * @package  ParamsService.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Intl\Languages;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * PHP version 7
 *
 * @category App\Service
 * @package  ParamsService.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */
class ParamsService
{
    /**
     * Constante __FILE_CONFIG
     */
    public const __FILE_CONFIG = '/config/configuration.yaml';

    /**
     * Constante __FILE_CONFIG_OLD
     */
    public const __FILE_CONFIG_OLD = '/config/configuration_old.yaml';

    /**
     * Constante __FILE_TRANSLATIONS
     */
    public const __FILE_TRANSLATIONS = '/translations/messages.xx.yaml';

    /**
     * Constante __FILE_TRANSLATIONS
     */
    public const __FILE_TRANSLATIONS_OLD = '/translations/messages_old.xx.yaml';

    /**
     * Variable $this->_params;
     *
     * @var ParameterBagInterface
     */
    private $_params;

    /**
     * Void __construct()
     *
     * @param ParameterBagInterface $params comment
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->_params = $params;
    }

    /**
     * Retourne les paramètres du fichier service.yaml
     *
     * @return void
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Gets a service container parameter.
     *
     * @param string $name The parameter name
     *
     * @return mixed The parameter value
     *
     * @throws ParameterNotFoundException if the parameter is not defined
     */
    public function get($name)
    {
        return $this->getParams()->get($name);
    }

    /**
     * Retourne en array le fichier configuration.yaml
     *
     * @return array
     */
    public function config(): array
    {
        return Yaml::parseFile(
            $this->getParams()->get("app_root").self::__FILE_CONFIG
        );
    } 
    
    /**
     * Retourne le nom du template front-end actif
     *
     * @return string
     */
    public function getTemplateFront(): string
    {
        return $this->config()['template']['front'];
    }

    /**
     * Retourne le nom du template back-end actif
     *
     * @return string
     */
    public function getTemplateBack(): string
    {
        return $this->config()['template']['back'];
    }
    
    /**
     * Retourne le fichier de traduction en tableau array
     * Selon la langue choisie
     *
     * @param string $_local fr, en, it etc etc 
     * 
     * @return array
     */
    public function getFileTranslation(string $_local): array
    {
        $file  = $this->getParams()->get("app_root");
        $file .= str_replace('xx', $_local, self::__FILE_TRANSLATIONS);

        if (file_exists($file)) {
            return Yaml::parseFile($file);
        } else {
            return array();
        }
    }

    /**
     * Retourne la langue du site actif
     *
     * @return string
     */
    public function locale(): string
    {
        return $this->getParams()->get('locale');
    }

    /**
     * Retourne un tableau des codes pays associés au nom du pays
     *
     * @return array
     */
    public function locales(): array
    {
        $locales = array();
        $explode = $this->localeCodes();
        foreach ($explode as $local) {
            $locales[$local] = ucfirst(Languages::getName($local, $local));
        }

        return $locales;
    }

    /**
     * Return un tableu de code des langues (utilisé aussi dans les controllers)
     */
    public function localeCodes(): array
    {
        return explode('|', $this->getParams()->get('app_locales'));
    }
}