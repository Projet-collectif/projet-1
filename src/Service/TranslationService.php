<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class TranslationService
{
    /**
     * @var ParameterBagInterface
     */
    private $_param;

    /**
     * @var array
     */
    private $_locales;

    public function __construct(ParameterBagInterface $parameterBagInterface)
    {
        $this->_param = $parameterBagInterface;
        $this->_locales = explode('|', $this->_param->get('app_locales'));
    }

    /**
     * Retourne la liste des locales de traduction dans services.yaml
     * 
     * @return string[]
     */
    public function getDefinedTranslations(): array
    {
        $locales = [];

        foreach ($this->_locales as $code) {
            $locales[$code] = $this->getLocaleName($code);
        }

        return  $locales;
    }

    /**
     * Retourne la liste des locales de traduction dans services.yaml
     * 
     * @return string[]
     */
    public function getTranslation(string $localeCode): array
    {
        $filename = $this->getTranslationFilename($localeCode);
        $data = [];

        if(file_exists($filename)) {
            try {
                $data = Yaml::parseFile($filename);
            } catch (ParseException $e) {
                printf('Unable to parse the YAML string: %s', $e->getMessage());
            }
        }

        return  $data;
    }

    /**
     * Met à jour un fichier de traduction (le crée s'il n'existe pas)
     * 
     * @param string $locale: Le code de la langue
     * @param string[] $data: Le tableau content les messages
     * @return bool: True en cas de succes, false sinon
     */
    public function updateTranslation(string $locale, array $data): bool
    {
        if(!in_array($locale, $this->_locales)) {
            return false;
        }

        $filename = $this->getTranslationFilename($locale);
        $newMessage = Yaml::dump($data);
        $oldMessages = '';

        if(file_exists($filename)) {
            $oldMessages = file_get_contents($filename);
            file_put_contents($filename.".old", $oldMessages);
        }

        file_put_contents($filename, $newMessage);

        return true;
    }

    /**
     * Return le langue correspondate à un code
     * 
     * @param string $code: Le code de la langue
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
     * @return string Le nom du fichier
     */
    private function getTranslationFilename(string $locale): string
    {
        return $this->_param->get('app_root') . '/translations/messages.' . $locale . '.yaml';
    }
}
