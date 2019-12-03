<?php

namespace App\Actions\Trick;

use App\Domain\Trick\Resolver;
use App\Responders\ViewResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateTrick
 * @package App\Actions\Trick
 *
 * @Route("/trick/new", name="trick_new")
 * @IsGranted("ROLE_USER")
 */
final class CreateTrick
{

    /** @var Resolver */
    protected $resolver;

    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __invoke(Request $request, ViewResponder $responder)
    {
        $form = $this->resolver->getFormType($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resolver->save($form->getData());
        }

        return $responder(
            'trick/new_edit.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
