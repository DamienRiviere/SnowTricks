<?php

namespace App\Domain\Account\Picture;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

final class Resolver
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    protected $uploadDir;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FlashBagInterface */
    protected $flash;

    public function __construct(
        FormFactoryInterface $formFactory,
        string $uploadDir,
        EntityManagerInterface $em,
        FlashBagInterface $flash
    ) {
        $this->formFactory = $formFactory;
        $this->uploadDir = $uploadDir;
        $this->em = $em;
        $this->flash = $flash;
    }

    public function getFormType(Request $request)
    {
        return $this->formFactory->create(PictureType::class)
                                 ->handleRequest($request);
    }

    public function update(UploadedFile $dto, User $user)
    {
        $user = User::updatePicture($dto, $user, $this->uploadDir);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function getFlashMessage()
    {
        return $this->flash->add(
            'bg-success',
            'Votre image de profil a bien été mise à jour !'
        );
    }
}
