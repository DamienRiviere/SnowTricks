<?php

namespace App\Actions\Account;

use App\Domain\Account\Picture\ResolverPicture;
use App\Repository\TrickLikeRepository;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class UpdatePicture
 * @package App\Actions\Account
 *
 * @Route("/account/picture", name="account_picture")
 * @IsGranted("ROLE_USER")
 */
final class UpdatePicture
{

    /** @var ResolverPicture */
    protected $resolver;

    /** @var Security */
    protected $security;

    /** @var TrickLikeRepository */
    protected $likeRepo;

    public function __construct(ResolverPicture $resolver, Security $security, TrickLikeRepository $likeRepo)
    {
        $this->resolver = $resolver;
        $this->security = $security;
        $this->likeRepo = $likeRepo;
    }

    public function __invoke(Request $request, ViewResponder $responder, RedirectResponder $redirectResponder)
    {
        $form = $this->resolver->getFormType($request);
        $user = $this->security->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resolver->update($form->getData()->getPicture(), $user);

            $this->resolver->getFlashMessage();

            return $redirectResponder(
                'account_index'
            );
        }

        return $responder(
            'account/edit_picture.html.twig',
            [
                'form' => $form->createView(),
                'likes' =>  $this->likeRepo->findBy(
                    ['user' =>  $this->security->getUser()->getId()]
                )
            ]
        );
    }
}
