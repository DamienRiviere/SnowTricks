<?php

namespace App\Domain\Trick;

use Symfony\Component\Validator\Constraints as Assert;

final class PictureDTO
{

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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link): void
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param mixed $alt
     */
    public function setAlt($alt): void
    {
        $this->alt = $alt;
    }
}
