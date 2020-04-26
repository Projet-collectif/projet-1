<?php

/**
 * PHP version 7
 *
 * @category App\Helper
 * @package  FormTextTrait.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */

namespace App\Helper;

/**
 * PHP version 7
 *
 * @category App\Helper
 * @package  FormTextTrait.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */
trait FormTextTrait
{
    /**
     *  Cette méthode permet de supprimer tout les caractères spéciaux d’une chaîne.
     *
     * @param string $text comment
     * 
     * @return string
     */
    public function removeSpecialChar(string $text): string
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $text);
    }
    
    /**
     * Remplace tous les accents par leur équivalent sans accent.
     *
     * @param string $text comment
     * 
     * @return string
     */
    public function enleveAccents(string $text): string 
    {
        return str_replace(
            array(
                "À","Á","Â","Ã","Ä","Å","à","á","â","ã","ä","å",
                "Ò","Ó","Ô","Õ","Ö","Ø","ò","ó","ô","õ","ö","ø",
                "È","É","Ê","Ë","è","é","ê","ë",
                "Ç","ç",
                "Ì","Í","Î","Ï","ì","í","î","ï",
                "Ù","Ú","Û","Ü","ù","ú","û","ü",
                "ÿ",
                "Ñ","ñ"
            ), 
            array(
                "a","a","a","a","a","a","a","a","a","a","a","a",
                "o","o","o","o","o","o","o","o","o","o","o","o",
                "e","e","e","e","e","e","e","e",
                "c","c",
                "i","i","i","i","i","i","i","i",
                "u","u","u","u","u","u","u","u",
                "y",
                "n","n"
            ), 
            $text
        );
    }

    /**
     * Formate un text pour un slug bdd
     *
     * @param string $text comment
     * 
     * @return string
     */
    public function slug(string $text): string
    {
        return str_replace(
            array(" ", "'"), 
            array("-", ""), 
            $text
        );
    }

}