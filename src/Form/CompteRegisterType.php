<?php

/**
 * PHP version 7
 *
 * @category App\Form
 * @package  CompteRegisterType.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

namespace App\Form;

/**
 * PHP version 7
 *
 * @category App\Form
 * @package  CompteRegisterType.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

use App\Entity\Compte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * PHP version 7
 *
 * @category App\Form
 * @package  CompteRegisterType.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */
class CompteRegisterType extends AbstractType
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
                'nom', TextType::class, [
                    'label' => 'NOM',
                    'label_attr' => [
                        'class' => '',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'EX-NOM'
                    ],
                    'required' => true,
                    'help' => 'HELP-REGISTER-NOM',
                    'help_html' => true,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'ASSET-NOT-BLANK-NOM',
                            ]
                        ), 
                        new Length(
                            [
                                'min' => 3,
                                'minMessage' => 'ASSETS-MIN-MESSAGE-NOM',
                                'max' => 30, 
                                'maxMessage' => 'ASSETS-MAX-MESSAGE-NOM',
                            ]
                        ),
                        new Regex(
                            [
                                'pattern' => '/^[a-zA-Z0-9-]+$/',
                                'match'   => true,
                                'message' => 'CONTRAINTS-REGEX-NOM'
                            ]
                        ),       
                    ],
                ]
            )
            ->add(
                'prenom', TextType::class, [
                    'label' => 'PRENOM',
                    'label_attr' => [
                        'class' => '',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'EX-PRENOM'
                    ],
                    'required' => true,
                    'help' => '',
                    'help_html' => true,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'ASSET-NOT-BLANK-PRENOM',
                            ]
                        ), 
                        new Length(
                            [
                                'min' => 3,
                                'minMessage' => 'ASSETS-MIN-MESSAGE-PRENOM',
                                'max' => 30, 
                                'maxMessage' => 'ASSETS-MAX-MESSAGE-PRENOM',
                            ]
                        ),
                        new Regex(
                            [
                                'pattern' => '/^[a-zA-Z0-9-]+$/',
                                'match'   => true,
                                'message' => 'CONTRAINTS-REGEX-PRENOM'
                            ]
                        ),       
                    ],
                ]
            )
            ->add(
                'adresse', TextType::class, [
                    'label' => 'ADRESSE',
                    'label_attr' => [
                        'class' => '',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'EX-ADRESSE'
                    ],
                    'required' => true,
                    'help' => '',
                    'help_html' => true,
                ]
            )
            ->add(
                'code_postal', TextType::class, [
                    'label' => 'CODE-POSTAL',
                    'label_attr' => [
                        'class' => '',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => ''
                    ],
                    'required' => true,
                    'help' => '',
                    'help_html' => true,
                ]
            )
            ->add(
                'ville', TextType::class, [
                    'label' => 'VILLE',
                    'label_attr' => [
                        'class' => '',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => ''
                    ],
                    'required' => true,
                    'help' => '',
                    'help_html' => true,
                ]
            )
            ->add(
                'pseudo', TextType::class, [
                    'label' => 'PSEUDO',
                    'label_attr' => [
                        'class' => '',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'EX-PSEUDO'
                    ],
                    'required' => true,
                    'help' => '',
                    'help_html' => true,
                ]
            )
            ->add(
                'website', TextType::class, [
                    'label' => 'YOUR-WEBSITE',
                    'label_attr' => [
                        'class' => '',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'EX-WEBSITE'
                    ],
                    'required' => true,
                    'help' => '',
                    'help_html' => true,
                ]
            )
            ->add(
                'avatar', TextType::class, [
                    'label' => 'YOUR-AVATAR',
                    'label_attr' => [
                        'class' => '',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => ''
                    ],
                    'required' => false,
                    'help' => '',
                    'help_html' => true,
                ]
            )
            ->add(
                'avatar', FileType::class, [
                    'label' => 'YOUR-AVATAR',
                    'attr' => [
                        'class' => 'form-control custom-file-input',
                        'accept' => '', 
                        'lang' => 'fr',
                    ],
                    'required' => false,
                    'constraints' => [
                        new File(
                            [
                                'maxSize' => '1000000',
                                'mimeTypes' => '',
                                'mimeTypesMessage' => '',
                            ]
                        )
                    ],
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
                'data_class' => Compte::class,
            ]
        );
    }
}
