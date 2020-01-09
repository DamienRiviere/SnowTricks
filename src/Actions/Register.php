<?php

namespace App\Actions;

use App\Domain\Register\ResolverRegister;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Register
 * @package App\Actions
 * @Route("/register", name="register_index")
 */
final class Register
{

    /** @var ResolverRegister  */
    protected $resolverRegister;

    public function __construct(ResolverRegister $resolverRegister)
    {
        $this->resolverRegister = $resolverRegister;
    }

    public function __invoke(Request $request, ViewResponder $responder, RedirectResponder $redirectResponder)
    {
        $form = $this->resolverRegister->getFormType($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resolverRegister->save($form->getData());
            $this->resolverRegister->getFlashMessage();

            return $redirectResponder(
                'auth_login'
            );
        }

        return $responder(
            'register/index.html.twig',
            [
                'form'  => $form->createView()
            ]
        );
    }
}
