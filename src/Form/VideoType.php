<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,  ['label' => 'Ajouter un titre'])

            ->add('content', FileType::class, [
            'label' => 'Uploadez la vidéo',

            // Unmapped means that this field is not associated to any entity property !
            'mapped' => false,

            // Make it optional so you don't have to re-upload the Video file !
            // Every time you edit the Video details !
            'required' => false,

            // unmapped fields can't define their validation using annotations !
            //'multiple' => true,

            // In the associated entity, so you can use the PHP constraint classes !
            'constraints' => [

                  new File([
                    'maxSize' => '15M',
                    'mimeTypes' => [
                        'video/mp4',
                        'application/x-mpegURL',
                        'video/MP2T'
                    ],
                    'mimeTypesMessage' => 'Veuillez charger une vidéo valide (webp, png, jpeg ou gif)',
                  ]),
                ],
              ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
