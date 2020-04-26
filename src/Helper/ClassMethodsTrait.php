<?php

/**
 * PHP version 7
 *
 * @category App\Helper
 * @package  ClassMethodsTrait.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */

namespace App\Helper;

/**
 * PHP version 7
 *
 * @category App\Helper
 * @package  ClassMethodsTrait.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */
trait ClassMethodsTrait
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
}