<?php

namespace App\Actions\Trick;

use App\Domain\Services\Pagination;
use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class LoadMoreTrick
 * @package App\Actions\Trick
 *
 * @Route("/tricks", name="trick_load_more", methods={"GET"})
 */
final class LoadMoreTrick
{

    /** @var TrickRepository */
    protected $trickRepo;

    /** @var Environment */
    protected $templating;

    /** @var Pagination */
    protected $pagination;

    public function __construct(TrickRepository $trickRepo, Environment $templating, Pagination $pagination)
    {
        $this->trickRepo = $trickRepo;
        $this->templating = $templating;
        $this->pagination = $pagination;
    }

    public function __invoke(Request $request)
    {
        $page = $request->query->get('page');
        $tricks = $this->trickRepo->loadTricks($this->pagination->getOffset($page), Trick::LIMIT_PER_PAGE);

        return new Response(
            json_encode(
                [
                    'html' => $this->templating->render('partials/_load_more.html.twig', ['tricks' => $tricks]),
                    'pages' => $this->pagination->getPages()
                ]
            ),
            200,
            [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
