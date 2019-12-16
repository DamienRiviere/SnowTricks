<?php

namespace App\Actions\Trick;

use App\Domain\Trick\ResolverTrick;
use App\Repository\TrickRepository;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UpdateTrick
 * @package App\Actions\Trick
 *
 * @Route("/trick/edit/{slug}", name="trick_edit")
 * @IsGranted("ROLE_USER")
 */
final class UpdateTrick
{

    /** @var ResolverTrick */
    protected $resolver;

    /** @var TrickRepository */
    protected $trickRepo;

    public function __construct(ResolverTrick $resolver, TrickRepository $trickRepo)
    {
        $this->resolver = $resolver;
        $this->trickRepo = $trickRepo;
    }

    public function __invoke(Request $request, ViewResponder $responder, RedirectResponder $redirectResponder)
    {
        $trick = $this->trickRepo->findOneBy(['slug' => $request->attributes->get('slug')]);
        $form = $this->resolver->getFormType($request, $trick);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $this->resolver->update($form->getData(), $trick);

            return $redirectResponder(
                'trick_show',
                [
                    'slug'  =>  $trick->getSlug()
                ]
            );
        }

        return $responder(
            'trick/new_edit.html.twig',
            [
                'form' => $form->createView(),
                'trick' => $trick
            ]
        );
    }
}
