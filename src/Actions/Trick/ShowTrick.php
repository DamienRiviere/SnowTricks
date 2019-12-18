<?php

namespace App\Actions\Trick;

use App\Domain\Comment\Resolver;
use App\Entity\Trick;
use App\Repository\TrickLikeRepository;
use App\Responders\ViewResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class ShowTrick
 * @package App\Actions
 *
 * @Route("/trick/{slug}", name="trick_show")
 */
final class ShowTrick
{
    /** @var Resolver */
    protected $resolver;

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var TrickLikeRepository */
    protected $likeRepo;

    /** @var Security */
    protected $security;

    public function __construct(
        FormFactoryInterface $formFactory,
        Resolver $resolver,
        TrickLikeRepository $likeRepo,
        Security $security
    ) {
        $this->formFactory = $formFactory;
        $this->resolver = $resolver;
        $this->likeRepo = $likeRepo;
        $this->security = $security;
    }

    /**
     * @param ViewResponder $responder
     * @param Trick $trick
     * @param Request $request
     * @return Response
     */
    public function __invoke(ViewResponder $responder, Trick $trick, Request $request)
    {
        $form = $this->resolver->getFormType($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resolver->save($form->getData(), $trick);
        }

        $like = null;

        if ($this->security->getUser()) {
            $like = $this->likeRepo->findOneBy([
                'user'  =>  $this->security->getUser()->getId(),
                'trick' =>  $trick->getId()
            ]);
        }

        return $responder(
            'trick/show.html.twig',
            [
                'trick' => $trick,
                'form'  => $form->createView(),
                'like'  => $like
            ]
        );
    }
}
