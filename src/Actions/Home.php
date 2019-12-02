<?php

namespace App\Actions;

use App\Repository\TrickRepository;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Home
 * @package App\Actions
 *
 * @Route("/", name="home")
 */
class Home
{

    /** @var TrickRepository */
    protected $trickRepo;

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
                'tricks' => $this->trickRepo->findBy([], ['createdAt' => 'DESC'])
            ]
        );
    }
}
