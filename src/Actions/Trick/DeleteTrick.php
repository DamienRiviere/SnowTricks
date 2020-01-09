<?php

namespace App\Actions\Trick;

use App\Domain\Trick\ResolverTrick;
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

    /** @var ResolverTrick */
    protected $resolverTrick;

    public function __construct(
        EntityManagerInterface $em,
        ResolverTrick $resolverTrick
    ) {
        $this->em = $em;
        $this->resolverTrick = $resolverTrick;
    }

    public function __invoke(Trick $trick, RedirectResponder $responder)
    {
        $this->resolverTrick->deleteTrick($trick);
        $this->resolverTrick->getFlashMessageDelete();

        return $responder(
            "home"
        );
    }
}
