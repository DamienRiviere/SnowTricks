<?php

namespace App\Domain\Trick;

use App\Domain\Common\Validators\UniqueEntityInput;
use App\Entity\Style;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom',
                    'attr' => [
                        'placeholder' => 'Nom du trick'
                    ]
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Description',
                    'attr' => [
                        'placeholder' => 'Description du trick'
                    ]
                ]
            )
            ->add(
                'style',
                EntityType::class,
                [
                    'class' =>  Style::class,
                    'choice_label' => 'name',
                    'expanded' => true,
                    'label' => 'Style de trick'
                ]
            )
            ->add(
                'pictures',
                CollectionType::class,
                [
                    'entry_type' => PictureType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'label' => false
                ]
            )
            ->add(
                'videos',
                CollectionType::class,
                [
                    'entry_type' => VideoType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'label' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => TrickDTO::class,
            ]
        );
    }
}
