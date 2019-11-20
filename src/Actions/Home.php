<?php

namespace App\Actions;

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

    /**
     * @param ViewResponder $responder
     * @return Response
     */
    public function __invoke(ViewResponder $responder)
    {
        return $responder(
            'base.html.twig'
        );
    }
}
