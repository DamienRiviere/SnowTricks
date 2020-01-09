<?php

namespace App\Actions\Account;

use App\Domain\Account\Password\ResolverPassword;
use App\Repository\TrickLikeRepository;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class UpdatePassword
 * @package App\Actions\Account
 *
 * @Route("/account/password", name="account_password")
 * @IsGranted("ROLE_USER")
 */
final class UpdatePassword
{
    /** @var ResolverPassword  */
    protected $resolverPassword;

    /** @var Security */
    protected $security;

    /** @var TrickLikeRepository */
    protected $likeRepo;

    public function __construct(ResolverPassword $resolverPassword, Security $security, TrickLikeRepository $likeRepo)
    {
        $this->resolverPassword = $resolverPassword;
        $this->security = $security;
        $this->likeRepo = $likeRepo;
    }

    public function __invoke(ViewResponder $responder, Request $request, RedirectResponder $redirectResponder)
    {
        $form = $this->resolverPassword->getFormType($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resolverPassword->update($form->getData(), $this->security->getUser());
            $this->resolverPassword->getFlashMessage();

            return $redirectResponder(
                'account_index'
            );
        }

        return $responder(
            'account/update_password.html.twig',
            [
                'form'  => $form->createView(),
                'likes' =>  $this->likeRepo->findBy(
                    ['user' =>  $this->security->getUser()->getId()]
                )
            ]
        );
    }
}
