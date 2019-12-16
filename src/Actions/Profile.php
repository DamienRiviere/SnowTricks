<?php

namespace App\Actions;

use App\Repository\UserRepository;
use App\Responders\ViewResponder;
use Symfony\Component\Routing\Annotation\Route;

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

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function __invoke(ViewResponder $responder, string $slug)
    {
        $user = $this->userRepo->findOneBy(['slug' => $slug]);

        return $responder(
            'profile/index.html.twig',
            [
                'user'  => $user
            ]
        );
    }
}
