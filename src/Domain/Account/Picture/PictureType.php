<?php

namespace App\Domain\Account\Picture;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PictureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            );
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
