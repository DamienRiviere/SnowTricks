<?php

namespace App\Domain\Trick;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PictureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Titre de l\'image'
                    ]
                ]
            )
            ->add(
                'picture',
                FileType::class,
                [
                    'label' => false,
                    'required' => false,
                    'data_class' => null,
                    'attr' => [
                        'placeholder' => 'Image à upload'
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => PictureDTO::class
            ]
        );
    }
}
