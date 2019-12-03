<?php

namespace App\Actions\Trick;

use App\Domain\Trick\Resolver;
use App\Repository\TrickRepository;
use App\Responders\ViewResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EditTrick
 * @package App\Actions\Trick
 *
 * @Route("/trick/edit/{slug}", name="trick_edit")
 * @IsGranted("ROLE_USER")
 */
final class EditTrick
{

    /** @var Resolver */
    protected $resolver;

    /** @var TrickRepository */
    protected $trickRepo;

    public function __construct(Resolver $resolver, TrickRepository $trickRepo)
    {
        $this->resolver = $resolver;
        $this->trickRepo = $trickRepo;
    }

    public function __invoke(Request $request, ViewResponder $responder)
    {
        $trick = $this->trickRepo->findOneBy(['slug' => $request->attributes->get('slug')]);
        $form = $this->resolver->getFormType($request, $trick);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resolver->update($form->getData(), $trick);
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
