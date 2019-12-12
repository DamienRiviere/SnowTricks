<?php

namespace App\Domain\Account\Email;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

final class Resolver
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FlashBagInterface */
    protected $flash;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $em, FlashBagInterface $flash)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->flash = $flash;
    }

    public function getFormType(Request $request, string $email): FormInterface
    {
        $emailDto = EmailDTO::updateToDto($email);

        return $this->formFactory->create(EmailType::class, $emailDto)
                                 ->handleRequest($request);
    }

    public function update(EmailDTO $dto, User $user)
    {
        $user = User::editEmail($dto, $user);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function getFlashMessage()
    {
        return $this->flash->add(
            "bg-success",
            "Votre adresse email a bien été modifier !"
        );
    }
}
