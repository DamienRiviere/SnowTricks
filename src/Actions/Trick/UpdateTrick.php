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
 * @Route("/trick/update/{slug}", name="trick_update")
 * @IsGranted("ROLE_USER")
 */
final class UpdateTrick
{

    /** @var ResolverTrick */
    protected $resolverTrick;

    /** @var TrickRepository */
    protected $trickRepo;

    public function __construct(ResolverTrick $resolverTrick, TrickRepository $trickRepo)
    {
        $this->resolverTrick = $resolverTrick;
        $this->trickRepo = $trickRepo;
    }

    public function __invoke(Request $request, ViewResponder $responder, RedirectResponder $redirectResponder)
    {
        $trick = $this->trickRepo->findOneBy(['slug' => $request->attributes->get('slug')]);
        $form = $this->resolverTrick->getFormType($request, $trick);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick = $this->resolverTrick->update($form->getData(), $trick);

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
