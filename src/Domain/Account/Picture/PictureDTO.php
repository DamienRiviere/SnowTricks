<?php

namespace App\Domain\Account\Picture;

use Symfony\Component\Validator\Constraints as Assert;

final class PictureDTO
{

    /**
     * @Assert\File(
     *     maxSize = "3000k",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/png"},
     *     mimeTypesMessage = "Le format de l'image doit être du JPEG, JPG ou PNG !"
     * )
     * @Assert\NotBlank(
     *     message = "Le champ de l'image ne doit pas être vide !"
     * )
     */
    protected $picture;

    public function getPicture()
    {
        return $this->picture;
    }
    
    public function setPicture($picture): void
    {
        $this->picture = $picture;
    }
}
