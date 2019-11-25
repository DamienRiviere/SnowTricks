<?php

namespace App\Actions\Trick;

use App\Domain\Trick\CreateTrick\CreateTrickDTO;
use App\Domain\Trick\CreateTrick\Resolver;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateTrick
 * @package App\Actions\Trick
 *
 * @Route("/trick/new", name="trick_new")
 */
class CreateTrick
{

    /** @var Resolver */
    protected $resolver;

    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param Request $request
     * @param ViewResponder $responder
     * @return Response
     */
    public function __invoke(Request $request, ViewResponder $responder)
    {
        $form = $this->resolver->getFormType($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resolver->save($form->getData());
        }

        return $responder(
            'tricks/new.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
