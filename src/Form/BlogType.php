<?php

/**
 * PHP version 7
 *
 * @category App\Form
 * @package  BlogType.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

namespace App\Form;

/**
 * PHP version 7
 *
 * @category App\Form
 * @package  BlogType.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

use App\Entity\Blog;
use App\Entity\User;
use App\Entity\Compte;
use App\Entity\Categories;
use App\Service\ParamsService;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * PHP version 7
 *
 * @category App\Form
 * @package  BlogType.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */
class BlogType extends AbstractType
{
    /**
     * Variable $this->_locale
     *
     * @var array
     */
    private $_locale;

    /**
     * Variable $this->_locales
     *
     * @var array
     */
    private $_locales = [];

    /**
     * Void __construct()
     * 
     * @param ParamsService $params comment
     */
    public function __construct(ParamsService $params) 
    {
        $this->_locale = $params->locale();
        $locales = $params->locales();
        foreach ($locales as $key => $value) {
            $this->_locales[$value] = $key;
        }
    }

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
                'language', ChoiceType::class, [
                    'label' => 'LANGUAGE',
                    'label_attr' => [
                        'class' => '',
                    ],
                    'choices' => $this->_locales,
                    'placeholder' => 'SELECTED',
                    'required' => true,
                    'help' => '',
                    'help_html' => true,
                ]
            )
            ->add(
                'title', TextType::class, [
                    'label' => 'TITLE',
                    'label_attr' => [
                        'class' => '',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'required' => true,
                    'help' => 'HELP-BLOG-TITLE',
                    'help_html' => true,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'ASSET-NOT-BLANK-BLOG-TITLE',
                            ]
                        ), 
                        new Length(
                            [
                                'min' => 3,
                                'minMessage' => 'ASSETS-MIN-MESSAGE-BLOG-TITLE',
                                'max' => 255, 
                                'maxMessage' => 'ASSETS-MAX-MESSAGE-BLOG-TITLE',
                            ]
                        ),
                        new Regex(
                            [
                                'pattern' => '/^[a-zA-Z0-9-_\'\s]+$/',
                                'match'   => true,
                                'message' => 'CONTRAINTS-REGEX-BLOG-TITLE'
                            ]
                        ),       
                    ],
                ]
            )
            ->add(
                'content', TextareaType::class, [
                    'label' => 'CONTENT',
                    'label_attr' => [
                        'class' => 'mr-2 mt-1 mb-1',
                    ],
                    'attr' => [
                        'class' => 'form-control form-textarea',
                    ],
                    'required' => true,
                    'help' => '',
                    'help_html' => true,
                ]
            )
            ->add(
                'compte', EntityType::class, [
                    'class' => Compte::class,
                    'query_builder' => function (EntityRepository $qb) {
                        return $qb->createQueryBuilder('C')
                            ->join(User::class, 'U', 'WITH', 'U.id = C.user')
                            //->where('U.roles LIKE :role')
                            ->andWhere('U.banned = :banned')
                            ->andWhere('U.is_active = :active')
                            //->setParameter('role', '%"'.'ROLE_REDACTEUR'.'"%')
                            ->setParameter('banned', false)
                            ->setParameter('active', true)
                            ->orderBy('C.nom', 'ASC');
                    },
                    'label' => 'AUTHOR',
                    'choice_label' => function (Compte $compte) {
                        $return  = $compte->getNom().' ';
                        $return .= $compte->getPrenom();
                        $return .= ' ('.strtolower(
                            str_replace(
                                "ROLE_", 
                                "", 
                                $compte->getUser()->getRoles()[0]
                            )
                        ).')';
                        return $return;
                    },
                    'choice_value' => 'id',
                    'placeholder' => 'SELECTED',
                    'required' => true,
                    'help' => '',
                    'help_html' => true,
                ]
            )
            ->add(
                'category', EntityType::class, [
                    'class' => Categories::class,
                    'label' => 'CATEGORIES',
                    'choice_label' => 'name',
                    'choice_value' => 'id',
                    'placeholder' => 'SELECTED',
                    'required' => true,
                    'help' => '',
                    'help_html' => true,
                ]
            )
            ->add(
                'new_image', FileType::class, [
                    'label' => 'IMAGE',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'CHOICE-EMPTY-INPUT',
                    ],
                    'required' => false,
                    'help' => 'FORMAT-VALID-IMAGE',
                    'help_html' => true,
                    'constraints' => [
                        new File(
                            [
                                'mimeTypes' => [
                                    'image/png',
                                    'image/jpeg',
                                    'image/pjpeg',
                                ],
                                'mimeTypesMessage' => 'FORMAT-VALID-IMAGE',
                            ]
                        )
                    ],
                ]
            )
            ->add(
                'metadesc', TextType::class, [
                    'label' => 'METADESC',
                    'label_attr' => [
                        'class' => 'mr-2 mt-1 mb-1',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'required' => true,
                    'help' => 'HELP-BLOG-METADESC',
                    'help_html' => true,
                ]
            )
            ->add(
                'metakeys', TextType::class, [
                    'label' => 'METAKEYS',
                    'label_attr' => [
                        'class' => 'mr-2 mt-1 mb-1',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'required' => true,
                    'help' => 'HELP-BLOG-METAKEYS',
                    'help_html' => true,
                ]
            )
            ->add(
                'publish', CheckboxType::class, [
                    'label' => 'PUBLISH',
                    'label_attr' => [
                        'class' => 'switch switch-left-right',
                    ],
                    'attr' => [
                        'class' => 'switch-input',
                    ],
                    'required' => false,
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
                'data_class' => Blog::class,
            ]
        );
    }
}
