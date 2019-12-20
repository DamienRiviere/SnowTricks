<?php

namespace App\Domain\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;

final class SetDisabledNameFieldListener implements EventSubscriberInterface
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

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $route = $this->request->getCurrentRequest()->attributes->get("_route");

        if ($route === "trick_update") {
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
}
