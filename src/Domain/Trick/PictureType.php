<?php

namespace App\Domain\Trick;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PictureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'link',
                UrlType::class,
                [
                    'attr' => [
                        'placeholder' => 'URL de l\'image'
                    ]
                ]
            )
            ->add(
                'alt',
                TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'Description de l\'image'
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
