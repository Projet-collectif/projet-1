<?php

namespace App\Form;

use App\Entity\Compte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
                    'help' => '',
                    'help_html' => true,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'ASSET-NOT-BLANK-NAME',
                            ]
                        ), 
                        new Length(
                            [
                                'min' => 3,
                                'minMessage' => 'ASSETS-MIN-MESSAGE-NAME',
                                'max' => 30, 
                                'maxMessage' => 'ASSETS-MAX-MESSAGE-NAME',
                            ]
                        ),
                        new Regex(
                            [
                                'pattern' => '/^[a-zA-Z0-9-]+$/',
                                'match'   => true,
                                'message' => 'CONTRAINTS-REGEX-NAME'
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
                                'message' => 'CONTRAINTS-REGEX-NAME'
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
                    'label' => 'WEBSITE',
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
                    'label' => 'AVATAR',
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
