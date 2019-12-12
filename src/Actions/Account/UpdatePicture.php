<?php

namespace App\Actions\Account;

use App\Domain\Account\Picture\Resolver;
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
                'form' => $form->createView()
            ]
        );
    }
}
