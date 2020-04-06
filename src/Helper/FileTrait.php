<?php

/**
 * PHP version 7
 *
 * @category App\Helper
 * @package  FileTrait.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */

namespace App\Helper;

/**
 * PHP version 7
 *
 * @category App\Helper
 * @package  FileTrait.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */
trait FileTrait
{
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