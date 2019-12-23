<?php

namespace App\Domain\Trick\Picture;

use App\Domain\Form\EventListener\AddNameFieldListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PictureType extends AbstractType
{

    /** @var RequestStack */
    protected $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => false,
                    'help'  => 'Titre de l\'image',
                    'attr' => [
                        'placeholder' => 'Titre de votre image ...'
                    ]
                ]
            )
            ->add(
                'picture',
                FileType::class,
                [
                    'label' => false,
                    'required' => false,
                    'help' => 'Image du trick',
                    'attr' => [
                        'placeholder' => 'Image à mettre en ligne ...'
                    ]
                ]
            )
            ->addEventSubscriber(new AddNameFieldListener($this->request))
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
