<?php

namespace App\Domain\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;

final class AddNameFieldListener implements EventSubscriberInterface
{

    /** @var RequestStack */
    protected $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData'
        ];
    }

    public function onPreSetData(FormEvent $event, $request)
    {
        $form = $event->getForm();
        $route = $this->request->getCurrentRequest()->attributes->get("_route");

        if ($route === "trick_update") {
            $form
                ->add(
                    'name',
                    TextType::class,
                    [
                        'label' => false,
                        'disabled' => true,
                        'help'  => 'Nom du fichier (Générer automatiquement)',
                        'attr' => [
                            'placeholder' => 'Nom du fichier ...'
                        ]
                    ]
                )
            ;
        }
    }
}
