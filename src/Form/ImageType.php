<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,  ['label' => 'Ajouter un titre'])

            ->add('content', FileType::class, [
            'label' => 'Uploadez l\'image',

            // Unmapped means that this field is not associated to any entity property !
            'mapped' => false,

            // Make it optional so you don't have to re-upload the Image file !
            // Every time you edit the Image details !
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
                        'image/jpeg'
                    ],
                    'mimeTypesMessage' => 'Veuillez charger une image valide (webp, png, jpeg ou gif)',
                  ]),
                ],
              ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
