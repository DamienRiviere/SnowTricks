<?php

namespace App\Actions\Trick;

use App\Domain\Trick\ResolverTrick;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NewTrick
 * @package App\Actions\Trick
 *
 * @Route("/trick/new", name="trick_new")
 * @IsGranted("ROLE_USER")
 */
final class NewTrick
{

    /** @var ResolverTrick */
    protected $resolver;

    public function __construct(ResolverTrick $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __invoke(Request $request, ViewResponder $responder, RedirectResponder $redirectResponder)
    {
        $form = $this->resolver->getFormType($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $this->resolver->save($form->getData());

            return $redirectResponder(
                'trick_show',
                [
                    'slug'  =>   $trick->getSlug()
                ]
            );
        }

        return $responder(
            'trick/new_edit.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
