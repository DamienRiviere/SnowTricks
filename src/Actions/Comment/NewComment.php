<?php

namespace App\Actions\Comment;

use App\Domain\Comment\ResolverComment;
use App\Entity\Trick;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class NewComment
 * @package App\Actions\Comment
 *
 * @Route("trick/{slug}/new-comment", name="trick_new_comment")
 * @IsGranted("ROLE_USER")
 */
final class NewComment
{

    /** @var ResolverComment */
    protected $resolverComment;

    /** @var Environment */
    protected $templating;

    public function __construct(ResolverComment $resolverComment, Environment $templating)
    {
        $this->resolverComment = $resolverComment;
        $this->templating = $templating;
    }

    public function __invoke(Trick $trick, Request $request)
    {
        $form = $this->resolverComment->getFormType($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $this->resolverComment->save($form->getData(), $trick);

            return new Response(
                json_encode(
                    [
                        'html' => $this->templating->render('partials/_comment.html.twig', ['comment' => $comment])
                    ]
                ),
                200,
                [
                    'Content-Type' => 'application/json'
                ]
            );
        }
    }
}
