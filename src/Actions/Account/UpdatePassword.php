<?php

namespace App\Actions\Account;

use App\Domain\Account\Password\ResolverPassword;
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
    protected $resolver;

    /** @var Security */
    protected $security;

    public function __construct(ResolverPassword $resolver, Security $security)
    {
        $this->resolver = $resolver;
        $this->security = $security;
    }

    public function __invoke(ViewResponder $responder, Request $request, RedirectResponder $redirectResponder)
    {
        $form = $this->resolver->getFormType($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resolver->update($form->getData(), $this->security->getUser());

            $this->resolver->getFlashMessage();

            return $redirectResponder(
                'account_index'
            );
        }

        return $responder(
            'account/edit_password.html.twig',
            [
                'form'  => $form->createView()
            ]
        );
    }
}