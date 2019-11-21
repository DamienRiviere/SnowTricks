<?php

namespace App\Actions;

use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ShowTricks
 * @package App\Actions
 *
 * @Route("/tricks", name="tricks_show")
 */
class ShowTricks
{

    /**
     * @param ViewResponder $responder
     * @return Response
     */
    public function __invoke(ViewResponder $responder)
    {
        return $responder(
            'tricks/show.html.twig'
        );
    }
}
