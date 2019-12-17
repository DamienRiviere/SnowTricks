<?php

namespace App\Actions\Account;

use App\Repository\TrickLikeRepository;
use App\Responders\ViewResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class Account
 * @package App\Actions\Account
 *
 * @Route("/account", name="account_index")
 * @IsGranted("ROLE_USER")
 */
final class Account
{

    /** @var TrickLikeRepository */
    protected $likeRepo;

    /** @var Security */
    protected $security;

    public function __construct(TrickLikeRepository $likeRepo, Security $security)
    {
        $this->likeRepo = $likeRepo;
        $this->security = $security;
    }

    public function __invoke(ViewResponder $responder)
    {
        return $responder(
            'account/index.html.twig',
            [
                'likes' =>  $this->likeRepo->findBy(
                    ['user' =>  $this->security->getUser()->getId()]
                )
            ]
        );
    }
}
