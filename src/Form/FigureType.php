<?php

namespace App\Form;

use App\Entity\Figure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;



class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('name', TextType::class,  ['label' => 'Nom de la figure'])

                ->add('description', TextareaType::class, [
                  'attr' => ['class' => 'tinymce'],
                  'label' => 'Description'
              ])

                ->add('category', ChoiceType::class, [
                    'choices'  => [
                        'Butters' => 'Butters',
                        'Spins' => 'Spins',
                        'Grabs' => 'Grabs',
                    ],
                ])

                ->add('file', FileType::class, [
                'label' => 'Image de couverture',

                // Unmapped means that this field is not associated to any entity property !
                'mapped' => false,

                // Make it optional so you don't have to re-upload the PDF file !
                // Every time you edit the Product details !
                'required' => false,

                // unmapped fields can't define their validation using annotations !

                //'multiple' => true,

                // In the associated entity, so you can use the PHP constraint classes !
                'constraints' => [

                      new File([
                        'maxSize' => '15M',
                        'mimeTypes' => [
                            'image/webp',
                            'image/png',
                            'image/gif',
                            'image/jpeg',
                            'video/mp4',
                            'application/x-mpegURL',
                            'video/MP2T'
                        ],
                        'mimeTypesMessage' => 'Veuillez charger une image valide (webp, png, jpeg ou gif)',
                      ]),
                    ],
                  ])
/*
                  ->add('title', FileType::class, [
                    'label' => 'Vidéos',

                    // Unmapped means that this field is not associated to any entity property !
                    'mapped' => false,

                    // Make it optional so you don't have to re-upload the Video file !
                    // Every time you edit the Video details !
                    'required' => false,

                    // unmapped fields can't define their validation using annotations !
                    'multiple' => true,

                    // In the associated entity, so you can use the PHP constraint classes !
                    'constraints' => [

                          new File([
                            'maxSize' => '15M',
                            'mimeTypes' => [
                                'image/webp',
                                'image/png',
                                'image/gif',
                                'image/jpeg',
                                'video/mp4',
                                'application/x-mpegURL',
                                'video/MP2T'
                            ],
                            'mimeTypesMessage' => 'Veuillez charger une image valide (webp, png, jpeg ou gif)',
                          ]),
                        ],
                      ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }

}
