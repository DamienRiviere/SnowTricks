<?php

namespace App\Domain\Account\Picture;

use App\Domain\Services\FileUploader;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

final class ResolverPicture
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    protected $uploadDirProfile;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FlashBagInterface */
    protected $flash;

    /** @var FileUploader  */
    protected $upload;

    public function __construct(
        FormFactoryInterface $formFactory,
        string $uploadDirProfile,
        EntityManagerInterface $em,
        FlashBagInterface $flash
    ) {
        $this->formFactory = $formFactory;
        $this->uploadDirProfile = $uploadDirProfile;
        $this->em = $em;
        $this->flash = $flash;
        $this->upload = new FileUploader($this->uploadDirProfile);
    }

    public function getFormType(Request $request)
    {
        return $this->formFactory->create(PictureType::class)
                                 ->handleRequest($request);
    }

    public function update(UploadedFile $dto, User $user)
    {
        if ($user->getPicture() != "default.png") {
            $this->deleteFile("uploads/profile/", $user);
        }

        $user = $this->updatePicture($dto, $user);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function updatePicture(UploadedFile $dto, User $user)
    {
        $newFileName = $this->upload->upload($dto);
        $user->setPicture($newFileName);

        return $user;
    }

    public function deleteFile($path, $user)
    {
        unlink($path . $user->getPicture());
    }

    public function getFlashMessage()
    {
        return $this->flash->add(
            'bg-success',
            'Votre image de profil a bien été mise à jour !'
        );
    }
}
