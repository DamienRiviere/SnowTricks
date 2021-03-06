<?php

namespace App\Actions\Trick;

use App\Domain\Trick\ResolverTrick;
use App\Entity\Trick;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UnlikeTrick
 * @package App\Actions\Trick
 *
 * @Route("trick/{id}/unlike", name="trick_unlike")
 * @Security("is_granted('ROLE_USER') and user != trick.getUser()",
 *     message="Vous ne pouvez pas ne plus aimer un trick si vous en êtes le créateur !"
 * )
 */
final class UnlikeTrick
{

    /** @var ResolverTrick */
    protected $resolverTrick;

    public function __construct(ResolverTrick $resolverTrick)
    {
        $this->resolverTrick = $resolverTrick;
    }

    public function __invoke(Trick $trick)
    {
        $this->resolverTrick->unlike($trick);
    }
}
