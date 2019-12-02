<?php

namespace App\Actions\Trick;

use App\Entity\Trick;
use App\Responders\RedirectResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteTrick
 * @package App\Actions\Trick
 *
 * @Route("/trick/delete/{id}", name="trick_delete")
 */
class DeleteTrick
{

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FlashBagInterface */
    protected $flash;

    public function __construct(EntityManagerInterface $em, FlashBagInterface $flash)
    {
        $this->em = $em;
        $this->flash = $flash;
    }

    public function __invoke(Trick $trick, RedirectResponder $responder)
    {
        $this->em->remove($trick);
        $this->em->flush();

        $this->flash->add(
            "bg-danger",
            "Le trick a bien été supprimer !"
        );

        return $responder(
            "home"
        );
    }
}
