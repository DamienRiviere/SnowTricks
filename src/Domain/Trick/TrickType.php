<?php

namespace App\Domain\Trick;

use App\Domain\Trick\Picture\PictureType;
use App\Domain\Trick\Video\VideoType;
use App\Entity\Style;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TrickType extends AbstractType
{

    /** @var RequestStack */
    protected $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

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
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [
                    $this,  'onPreSetData'
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

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $route = $this->requestStack->getCurrentRequest()->attributes->get("_route");

        if ($route === "trick_edit") {
            $form
                ->add(
                    'name',
                    TextType::class,
                    [
                        'label' => 'Nom',
                        'disabled' => 'true',
                        'attr' => [
                            'placeholder' => 'Nom du trick'
                        ]
                    ]
                )
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => TrickDTO::class,
                'validation_groups' => function (FormInterface $form) {
                    if ($form->getData()->getId()) {
                        return "Default";
                    }
                    return ["Default", "newTrick"];
                }
            ]
        );
    }
}
