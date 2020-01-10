<?php

namespace App\Actions;

use App\Entity\Trick;
use App\Repository\TrickLikeRepository;
use App\Repository\TrickRepository;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class Home
 * @package App\Actions
 *
 * @Route("/", name="home", methods={"GET", "POST"})
 */
final class Home
{

    /** @var TrickRepository */
    protected $trickRepo;

    /** @var Security */
    protected $security;

    public function __construct(TrickRepository $trickRepo)
    {
        $this->trickRepo = $trickRepo;
    }

    /**
     * @param ViewResponder $responder
     * @return Response
     */
    public function __invoke(ViewResponder $responder)
    {
        return $responder(
            'home/index.html.twig',
            [
                'tricks'    => $this->trickRepo->loadTricks(0, Trick::LIMIT_PER_PAGE),
                'nextPage'  => 2
            ]
        );
    }
}
