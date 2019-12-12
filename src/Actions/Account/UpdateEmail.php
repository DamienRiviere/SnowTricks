<?php

namespace App\Actions\Account;

use App\Domain\Account\Email\Resolver;
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

    /** @var Resolver */
    protected $resolver;

    /** @var Security */
    protected $security;

    public function __construct(Resolver $resolver, Security $security)
    {
        $this->resolver = $resolver;
        $this->security = $security;
    }

    public function __invoke(Request $request, ViewResponder $responder, RedirectResponder $redirectResponder)
    {
        $email = $this->security->getUser()->getEmail();
        $form = $this->resolver->getFormType($request, $email);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resolver->update($form->getData(), $this->security->getUser());

            $this->resolver->getFlashMessage();

            return $redirectResponder(
                'account_index'
            );
        }

        return $responder(
            'account/edit_email.html.twig',
            [
                'form'  =>  $form->createView()
            ]
        );
    }
}
