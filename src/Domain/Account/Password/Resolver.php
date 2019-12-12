<?php

namespace App\Domain\Account\Password;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Resolver
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var UserPasswordEncoderInterface */
    protected $encoder;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FlashBagInterface */
    protected $flash;

    public function __construct(
        FormFactoryInterface $formFactory,
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $em,
        FlashBagInterface $flash
    ) {
        $this->formFactory = $formFactory;
        $this->encoder = $encoder;
        $this->em = $em;
        $this->flash = $flash;
    }

    public function getFormType(Request $request)
    {
        return $this->formFactory->create(PasswordType::class)
                                 ->handleRequest($request);
    }

    public function update(PasswordDTO $dto, User $user)
    {
        $user = User::updatePassword($dto, $user, $this->encoder);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function getFlashMessage()
    {
        return $this->flash->add(
            'bg-success',
            'Votre mot de passe a bien été modifier !'
        );
    }
}
