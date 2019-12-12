<?php

namespace App\Domain\Account\Password;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType as PasswordTypeForm;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PasswordType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'password',
                PasswordTypeForm::class,
                [
                    'label' => false,
                    'attr'  => [
                        'placeholder' => 'Écrivez votre nouveau mot de passe !'
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'    =>  PasswordDTO::class
            ]
        );
    }
}
