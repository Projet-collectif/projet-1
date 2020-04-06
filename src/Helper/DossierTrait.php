<?php

/**
 * PHP version 7
 *
 * @category App\Helper
 * @package  DossierTrait.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */

namespace App\Helper;

/**
 * PHP version 7
 *
 * @category App\Helper
 * @package  DossierTrait.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */
trait DossierTrait
{
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
}