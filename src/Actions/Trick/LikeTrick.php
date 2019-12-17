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
 * @Security("is_granted('ROLE_USER') and user != trick.getUser()")
 */
final class LikeTrick
{

    /** @var ResolverTrick  */
    protected $resolver;

    public function __construct(ResolverTrick $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __invoke(Trick $trick)
    {
        $this->resolver->like($trick);
    }
}
