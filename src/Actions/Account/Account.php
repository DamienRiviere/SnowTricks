<?php

namespace App\Actions\Account;

use App\Responders\ViewResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Account
 * @package App\Actions\Account
 *
 * @Route("/account", name="account_index")
 * @IsGranted("ROLE_USER")
 */
final class Account
{

    public function __invoke(ViewResponder $responder)
    {
        return $responder(
            'account/index.html.twig'
        );
    }
}
