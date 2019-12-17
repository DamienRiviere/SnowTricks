<?php

namespace App\Actions;

use App\Repository\TrickLikeRepository;
use App\Repository\UserRepository;
use App\Responders\ViewResponder;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class Profile
 * @package App\Actions
 *
 * @Route("/profile/{slug}", name="profile_index")
 */
final class Profile
{

    /** @var UserRepository */
    protected $userRepo;

    /** @var TrickLikeRepository */
    protected $likeRepo;

    /** @var Security */
    protected $security;

    public function __construct(UserRepository $userRepo, TrickLikeRepository $likeRepo, Security $security)
    {
        $this->userRepo = $userRepo;
        $this->likeRepo = $likeRepo;
        $this->security = $security;
    }

    public function __invoke(ViewResponder $responder, string $slug)
    {
        $user = $this->userRepo->findOneBy(['slug' => $slug]);

        return $responder(
            'profile/index.html.twig',
            [
                'user'  => $user,
                'likes' =>  $this->likeRepo->findBy(
                    ['user' =>  $user->getId()]
                )
            ]
        );
    }
}
