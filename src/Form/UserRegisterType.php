<?php

/**
 * PHP version 7
 *
 * @category App\Form
 * @package  UserRegisterType.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

namespace App\Form;

/**
 * PHP version 7
 *
 * @category App\Form
 * @package  UserRegisterType.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

use App\Entity\User;
use App\Form\CompteRegisterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

/**
 * PHP version 7
 *
 * @category App\Form
 * @package  UserRegisterType.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */
class UserRegisterType extends AbstractType
{
    /**
     * Function buildForm
     *
     * @param FormBuilderInterface $builder comment
     * @param array                $options comment
     * 
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email', RepeatedType::class, [
                'type' => EmailType::class,
                'first_options' => array(
                    'label' => 'YOUR-EMAIL',
                    'help' => '',
                    'help_html' => true,
                ),
                'second_options' => array(
                    'label' => 'REPEAT-EMAIL',
                    'help' => '',
                    'help_html' => true,
                ),
                ]
            )
            ->add(
                'password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options' => array(
                        'label' => 'YOUR-PASSWORD',
                        'help' => '',
                        'help_html' => true,
                    ),
                    'second_options' => array(
                        'label' => 'REPEAT-PASSWORD',
                        'help' => '',
                        'help_html' => true,
                    ),
                ]
            )
            ->add(
                'compte', CompteRegisterType::class, [
                    'label' => 'REGISTER-ACCOUNT',
                ]
            );
    }

    /**
     * Function configureOptions
     *
     * @param OptionsResolver $resolver resolver
     * 
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
