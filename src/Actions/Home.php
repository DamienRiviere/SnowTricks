<?php

namespace App\Actions;

use App\Repository\TrickLikeRepository;
use App\Repository\TrickRepository;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class Home
 * @package App\Actions
 *
 * @Route("/", name="home")
 */
final class Home
{

    /** @var TrickRepository */
    protected $trickRepo;

    /** @var TrickLikeRepository */
    protected $likeRepo;

    /** @var Security */
    protected $security;

    public function __construct(TrickRepository $trickRepo, TrickLikeRepository $likeRepo, Security $security)
    {
        $this->trickRepo = $trickRepo;
        $this->likeRepo = $likeRepo;
        $this->security = $security;
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
                'tricks'    => $this->trickRepo->findBy([], ['createdAt' => 'DESC']),
                'likes'      => $this->likeRepo->findAll()
            ]
        );
    }
}
