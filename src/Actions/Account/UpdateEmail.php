<?php

namespace App\Actions\Account;

use App\Domain\Account\Email\ResolverEmail;
use App\Repository\TrickLikeRepository;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class UpdateEmail
 * @package App\Actions\Account
 *
 * @Route("/account/email", name="account_email")
 * @IsGranted("ROLE_USER")
 */
final class UpdateEmail
{

    /** @var ResolverEmail */
    protected $resolverEmail;

    /** @var Security */
    protected $security;

    /** @var TrickLikeRepository */
    protected $likeRepo;

    public function __construct(ResolverEmail $resolverEmail, Security $security, TrickLikeRepository $likeRepo)
    {
        $this->resolverEmail = $resolverEmail;
        $this->security = $security;
        $this->likeRepo = $likeRepo;
    }

    public function __invoke(Request $request, ViewResponder $responder, RedirectResponder $redirectResponder)
    {
        $email = $this->security->getUser()->getEmail();
        $form = $this->resolverEmail->getFormType($request, $email);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resolverEmail->update($form->getData(), $this->security->getUser());
            $this->resolverEmail->getFlashMessage();

            return $redirectResponder(
                'account_index'
            );
        }

        return $responder(
            'account/update_email.html.twig',
            [
                'form'  =>  $form->createView(),
                'likes' =>  $this->likeRepo->findBy(
                    ['user' =>  $this->security->getUser()->getId()]
                )
            ]
        );
    }
}
