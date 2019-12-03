<?php

namespace App\Actions\Authentication;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Logout
 * @package App\Actions\Authentication
 * @Route("/logout", name="auth_logout")
 */
class Logout
{

    public function __invoke()
    {
    }
}
