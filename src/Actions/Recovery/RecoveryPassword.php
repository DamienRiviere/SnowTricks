<?php

namespace App\Actions\Recovery;

use App\Domain\Recovery\ResolverPassword;
use App\Repository\UserRepository;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RecoveryPassword
 * @package App\Actions\Account
 *
 * @Route("/recovery-password/{token}", name="recovery_password")
 */
final class RecoveryPassword
{

    /** @var ResolverPassword  */
    protected $resolverPassword;

    public function __construct(ResolverPassword $resolverPassword)
    {
        $this->resolverPassword = $resolverPassword;
    }

    public function __invoke(Request $request, ViewResponder $responder, string $token, RedirectResponder $redirect)
    {
        $user = $this->resolverPassword->checkIfTokenExist($token);
        $tokenTime = $this->resolverPassword->checkTokenDate($user);

        if (is_null($user)) {
            return $redirect(
                'auth_login'
            );
        }

        if (!is_null($user) && $tokenTime > 15) {
            $this->resolverPassword->getFlashMessageTokenFalse();

            return $redirect(
                'auth_login'
            );
        }

        $form = $this->resolverPassword->getFormType($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resolverPassword->updatePassword($user, $form->getData());
            $this->resolverPassword->getFlashMessageSuccess();

            return $redirect(
                'auth_login'
            );
        }

        return $responder(
            'recovery/recovery_password.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
