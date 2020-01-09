<?php

namespace App\Actions\Trick;

use App\Domain\Trick\ResolverTrick;
use App\Entity\Trick;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LikeTrick
 * @package App\Actions\Trick
 *
 * @Route("/trick/{id}/like", name="trick_like")
 * @Security("is_granted('ROLE_USER') and user != trick.getUser()",
 *     message="Vous ne pouvez pas aimer un trick si vous en êtes le créateur !"
 * )
 */
final class LikeTrick
{

    /** @var ResolverTrick  */
    protected $resolverTrick;

    public function __construct(ResolverTrick $resolverTrick)
    {
        $this->resolverTrick = $resolverTrick;
    }

    public function __invoke(Trick $trick)
    {
        $this->resolverTrick->like($trick);
    }
}
