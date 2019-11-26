<?php

namespace App\Actions\Trick;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ShowTrick
 * @package App\Actions
 *
 * @Route("/trick/{slug}", name="trick_show")
 */
class ShowTrick
{
    /** @var TrickRepository */
    protected $trickRepo;

    public function __construct(TrickRepository $trickRepo)
    {
        $this->trickRepo = $trickRepo;
    }

    /**
     * @param ViewResponder $responder
     * @param Trick $trick
     * @return Response
     */
    public function __invoke(ViewResponder $responder, Trick $trick)
    {
        return $responder(
            'trick/show.html.twig',
            [
                'trick' => $trick
            ]
        );
    }
}
