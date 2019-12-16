<?php

namespace App\Domain\Account\Password;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ResolverPassword
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

    public function getFormType(Request $request): FormInterface
    {
        return $this->formFactory->create(PasswordType::class)
                                 ->handleRequest($request);
    }

    public function update(PasswordDTO $dto, User $user)
    {
        $user = $this->updatePassword($dto, $user);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function updatePassword(PasswordDTO $dto, User $user)
    {
        $user->setPassword($this->encoder->encodePassword($user, $dto->getPassword()));

        return $user;
    }

    public function getFlashMessage()
    {
        return $this->flash->add(
            'bg-success',
            'Votre mot de passe a bien été modifier !'
        );
    }
}
