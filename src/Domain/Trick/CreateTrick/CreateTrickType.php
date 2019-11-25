<?php

namespace App\Domain\Trick\CreateTrick;

use App\Entity\Style;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreateTrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom du trick'
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Description du trick'
                ]
            )
            ->add(
                'coverPicture',
                TextType::class,
                [
                    'label' => 'Image de couverture du trick'
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
                'pictureLink',
                TextType::class,
                [
                    'label' => 'Lien de l\'image'
                ]
            )
            ->add(
                'pictureAlt',
                TextType::class,
                [
                    'label' => 'Description de l\'image'
                ]
            )
            ->add(
                'videoLink',
                TextType::class,
                [
                    'label' => 'Lien de la vidéo'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => CreateTrickDTO::class,
            ]
        );
    }
}
