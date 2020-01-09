<?php

namespace App\Actions\Recovery;

use App\Domain\Recovery\ResolverSendEmail;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RecoverySendEmail
 * @package App\Actions\Recovery
 *
 * @Route("/password-forgot", name="password_forgot")
 */
final class RecoverySendEmail
{

    /** @var ResolverSendEmail */
    protected $resolverSendEmail;

    public function __construct(ResolverSendEmail $resolverSendEmail)
    {
        $this->resolverSendEmail = $resolverSendEmail;
    }

    public function __invoke(Request $request, ViewResponder $responder, RedirectResponder $redirect)
    {
        $form = $this->resolverSendEmail->getFormType($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->resolverSendEmail->saveRecovery($form->getData());
            $this->resolverSendEmail->getFlashMessage();
            $this->resolverSendEmail->checkUserAndSendEmail($user, $form->getData());

            return $redirect(
                'home'
            );
        }

        return $responder(
            'recovery/recovery_send_email.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
