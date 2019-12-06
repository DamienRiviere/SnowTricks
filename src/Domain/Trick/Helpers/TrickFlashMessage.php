<?php

namespace App\Domain\Trick\Helpers;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

final class TrickFlashMessage
{

    /** @var FlashBagInterface */
    protected $flash;

    public function __construct(FlashBagInterface $flash)
    {
        $this->flash = $flash;
    }

    public function getFlashMessageDelete()
    {
        return $this->flash->add(
            "bg-danger",
            "Le trick a bien été supprimer !"
        );
    }
}
