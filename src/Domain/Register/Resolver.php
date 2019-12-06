<?php

namespace App\Domain\Register;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class Resolver
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var UserPasswordEncoderInterface */
    protected $encoder;

    /** @var FlashBagInterface */
    protected $flash;

    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder,
        FlashBagInterface $flash
    ) {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->encoder = $encoder;
        $this->flash = $flash;
    }

    public function getFormType(Request $request)
    {
        return $this->formFactory->create(RegisterType::class)
                                 ->handleRequest($request);
    }

    public function getFlashMessage()
    {
        return $this->flash->add(
            'bg-success',
            'Votre compte a été créer avec succès, vous pouvez maintenant vous connecter avec vos identifiants !'
        );
    }

    public function save(RegisterDTO $dto)
    {
        $user = User::create($dto, $this->encoder);
        $this->em->persist($user);
        $this->em->flush();
    }
}
