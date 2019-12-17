<?php

namespace App\Actions\Trick;

use App\Domain\Trick\Helpers\TrickFlashMessage;
use App\Domain\Trick\Picture\ResolverPicture;
use App\Entity\Trick;
use App\Responders\RedirectResponder;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteTrick
 * @package App\Actions\Trick
 *
 * @Route("/trick/delete/{id}", name="trick_delete")
 * @Security("is_granted('ROLE_USER') and user === trick.getUser()")
 */
final class DeleteTrick
{

    /** @var EntityManagerInterface */
    protected $em;

    /** @var TrickFlashMessage */
    protected $flash;

    /** @var ResolverPicture */
    protected $resolver;

    public function __construct(EntityManagerInterface $em, TrickFlashMessage $flash, ResolverPicture $resolver)
    {
        $this->em = $em;
        $this->flash = $flash;
        $this->resolver = $resolver;
    }

    public function __invoke(Trick $trick, RedirectResponder $responder)
    {
        $this->resolver->deleteFiles("uploads/trick/", $trick->getPictures());
        $this->em->remove($trick);
        $this->em->flush();

        $this->flash->getFlashMessageDelete();

        return $responder(
            "home"
        );
    }
}
