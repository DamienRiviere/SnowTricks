<?php

namespace App\Domain\Trick\Picture;

use Symfony\Component\Validator\Constraints as Assert;

final class PictureDTO
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @Assert\NotBlank(
     *     message = "Le titre de l'image ne doit pas être vide"
     * )
     */
    protected $title;

    /**
     * @Assert\File(
     *     maxSize = "3000k",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/png"},
     *     mimeTypesMessage = "Le format de l'image doit être du JPEG, JPG ou PNG !"
     * )
     */
    protected $picture;

    /**
     * @var string|null
     */
    protected $name;

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

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }
    
    public function setPicture($picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }
}
