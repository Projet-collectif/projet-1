<?php

/**
 * PHP version 7
 *
 * @category App\Service
 * @package  FonctionsService.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */

namespace App\Service;

/**
 * PHP version 7
 *
 * @category App\Service
 * @package  FonctionsService.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */
class FonctionsService
{
    /**
     * Public function classMethods()
     * Retourne les noms des méthodes d'une classe
     * 
     * @param object $nameClass (Nom de la class)
     * @param string $method    null toutes les methodes, 
     *                          get retoune les getters, 
     *                          set retourne les setters.
     *
     * @return array
     */
    public function classMethods(object $nameClass, string $method = null): array
    {
        $class_methods = get_class_methods(get_class($nameClass));

        if ($method !== null) {
            $methods = array();
            foreach ($class_methods as $name_method) {
                if (substr($name_method, 0, 3) === $method) {
                    array_push($methods, $name_method);
                }
            }
        } else {
            $methods = $class_methods;
        }
        
        return $methods;
    }


    /**
     * Remplace tous les espaces.
     *
     * @param string $str comment
     * 
     * @return string
     */
    public function enleveEspaces(string $str): string 
    {
        return str_replace(" ", "-", $str);
    }


    /**
     * Remplace tous les accents par leur équivalent sans accent.
     *
     * @param string $str comment
     * 
     * @return string
     */
    public function enleveAccents(string $str): string 
    {
        $a = array(
            "À","Á","Â","Ã","Ä","Å","à","á","â","ã","ä","å",
            "Ò","Ó","Ô","Õ","Ö","Ø","ò","ó","ô","õ","ö","ø",
            "È","É","Ê","Ë","è","é","ê","ë",
            "Ç","ç",
            "Ì","Í","Î","Ï","ì","í","î","ï",
            "Ù","Ú","Û","Ü","ù","ú","û","ü",
            "ÿ",
            "Ñ","ñ"
        );
        $b = array(
            "a","a","a","a","a","a","a","a","a","a","a","a",
            "o","o","o","o","o","o","o","o","o","o","o","o",
            "e","e","e","e","e","e","e","e",
            "c","c",
            "i","i","i","i","i","i","i","i",
            "u","u","u","u","u","u","u","u",
            "y",
            "n","n"
        );

        return str_replace($a, $b, $str);
    }

    /**
     * Undocumented function
     *
     * @param string $slug comment
     * 
     * @return string
     */
    public function slug(string $slug): string
    {

        $a = array(" ", "'", "\"", ":", "/", "&");
        $b = array("-", "", "", "", "", "-");

        return str_replace($a, $b, $slug);
    }


    /**
     * Remplace tous les caractères spéciaux.
     *
     * @param string $str comment
     * 
     * @return string
     */
    public function enleveDiversCaracteres(string $str): string 
    {
        $a = array(
            "<",">","'",
        );
        $b = array(
            "","","",
        );

        return str_replace($a, $b, $str);
    }

    /**
     * Function qui créer un dossier
     *
     * @param string $url comment
     * 
     * @return boolean
     */
    public function createDossier(string $url): bool
    {
        if (!is_dir($url)) {
            mkdir($url, 0755);
            fopen($url.'/index.html', 'w+');
            return true;
        } else {
            return false;
        }
    } 
    

    /**
     * Function qui ouvre un fichier
     * et écris dans le fichier
     *
     * @param string $target comment
     * @param string $text   comment
     * 
     * @return void
     */
    public function openAndWriteFile(string $target, string $text): void
    {
        $fichier = fopen($target, 'w+');
        fwrite($fichier, $text);
        fclose($fichier);
    } 

}
