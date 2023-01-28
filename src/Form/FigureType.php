<?php

namespace App\Form;

use App\Entity\Figure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('category')
            ->add('file', FileType::class, [
            'label' => 'Image',

            // unmapped means that this field is not associated to any entity property
            'mapped' => false,

            // make it optional so you don't have to re-upload the PDF file
            // every time you edit the Product details
            'required' => false,

            // unmapped fields can't define their validation using annotations

            // 'multiple' => true,

            // in the associated entity, so you can use the PHP constraint classes
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
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (webp, png, jpeg ou gif)',
                      ]),
                    ],
                  ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }

}
