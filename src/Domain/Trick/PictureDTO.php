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
     * @var string
     * @Assert\NotBlank(
     *     message="Le lien de l'image ne doit pas être vide !"
     * )
     * @Assert\Url(
     *     message="Le lien de l'image doit être une URL !"
     * )
     */
    protected $link;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="La description de l'image ne doit pas être vide !"
     * )
     */
    protected $alt;

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

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlt()
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }
}
