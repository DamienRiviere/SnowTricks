<?php

namespace App\Actions\Trick;

use App\Domain\Comment\ResolverComment;
use App\Entity\Comment;
use App\Entity\Trick;
use App\Repository\CommentRepository;
use App\Repository\TrickLikeRepository;
use App\Responders\ViewResponder;
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
    /** @var ResolverComment */
    protected $resolverComment;

    /** @var TrickLikeRepository */
    protected $likeRepo;

    /** @var Security */
    protected $security;

    /** @var CommentRepository */
    protected $commentRepo;

    public function __construct(
        ResolverComment $resolverComment,
        TrickLikeRepository $likeRepo,
        Security $security,
        CommentRepository $commentRepo
    ) {
        $this->resolverComment = $resolverComment;
        $this->likeRepo = $likeRepo;
        $this->security = $security;
        $this->commentRepo = $commentRepo;
    }

    /**
     * @param ViewResponder $responder
     * @param Trick $trick
     * @param Request $request
     * @return Response
     */
    public function __invoke(ViewResponder $responder, Trick $trick, Request $request)
    {
        $form = $this->resolverComment->getFormType($request);

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
                'like'  => $like,
                'comments' => $this->commentRepo->loadComments(0, Comment::LIMIT_PER_PAGE, $trick),
                'nextPage' => 2
            ]
        );
    }
}
