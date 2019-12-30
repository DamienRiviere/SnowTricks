<?php

namespace App\Actions\Comment;

use App\Domain\Services\PaginationComment;
use App\Entity\Comment;
use App\Entity\Trick;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class LoadMoreComment
 * @package App\Actions\Comment
 *
 * @Route("/trick/{slug}/comment", name="comment_load_more", methods={"GET"})
 */
class LoadMoreComment
{

    /** @var Environment */
    protected $templating;

    /** @var PaginationComment */
    protected $pagination;

    /** @var CommentRepository */
    protected $commentRepo;

    public function __construct(Environment $templating, PaginationComment $pagination, CommentRepository $commentRepo)
    {
        $this->templating = $templating;
        $this->pagination = $pagination;
        $this->commentRepo = $commentRepo;
    }

    public function __invoke(Request $request, Trick $trick)
    {
        $page = $request->query->get('page');
        $comments = $this->commentRepo->loadComments(
            $this->pagination->getOffset($page),
            Comment::LIMIT_PER_PAGE,
            $trick
        );

        return new Response(
            json_encode(
                [
                    'html' => $this->templating->render(
                        'partials/_load_more_comments.html.twig',
                        [
                            'comments' => $comments
                        ]
                    ),
                    'pages' => $this->pagination->getPages($trick)
                ]
            ),
            200,
            [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
