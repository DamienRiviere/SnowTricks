<?php

namespace App\Actions\Trick;

use App\Domain\Trick\Helpers\TrickFlashMessage;
use App\Domain\Trick\Resolver;
use App\Entity\Trick;
use App\Responders\RedirectResponder;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteTrick
 * @package App\Actions\Trick
 *
 * @Route("/trick/delete/{id}", name="trick_delete")
 * @IsGranted("ROLE_USER")
 */
final class DeleteTrick
{

    /** @var EntityManagerInterface */
    protected $em;

    /** @var TrickFlashMessage */
    protected $flash;

    public function __construct(EntityManagerInterface $em, TrickFlashMessage $flash)
    {
        $this->em = $em;
        $this->flash = $flash;
    }

    public function __invoke(Trick $trick, RedirectResponder $responder)
    {
        $this->em->remove($trick);
        $this->em->flush();

        $this->flash->getFlashMessageDelete();

        return $responder(
            "home"
        );
    }
}
