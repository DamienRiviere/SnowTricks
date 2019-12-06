<?php

namespace App\Domain\Trick;

use Symfony\Component\Validator\Constraints as Assert;

final class PictureDTO
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string|null
     * @Assert\NotBlank(
     *     message = "Le titre de l'image ne doit pas être vide"
     * )
     */
    protected $title;

    /**
     * @Assert\NotBlank(
     *     message = "Le titre de l'image ne doit pas être vide !"
     * )
     * @Assert\File(
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/png"},
     *     mimeTypesMessage = "Le format de l'image doit être du JPEG, JPG ou PNG !"
     * )
     */
    protected $picture;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getPicture()
    {
        return $this->picture;
    }
    
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }
}
