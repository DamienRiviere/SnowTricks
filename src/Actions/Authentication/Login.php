<?php

namespace App\Actions\Authentication;

use App\Domain\Authentication\Login\LoginType;
use App\Responders\ViewResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class Login
 * @package App\Actions\Authentication
 * @Route("/login", name="auth_login")
 */
final class Login
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var AuthenticationUtils */
    protected $authenticationUtils;

    public function __construct(FormFactoryInterface $formFactory, AuthenticationUtils $authenticationUtils)
    {
        $this->formFactory = $formFactory;
        $this->authenticationUtils = $authenticationUtils;
    }

    public function __invoke(ViewResponder $responder)
    {
        $form = $this->formFactory->create(LoginType::class);

        return $responder(
            'auth/login.html.twig',
            [
                'form' => $form->createView(),
                'error' => $this->authenticationUtils->getLastAuthenticationError()
            ]
        );
    }
}
