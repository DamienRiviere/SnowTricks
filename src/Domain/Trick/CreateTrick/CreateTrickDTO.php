<?php

namespace App\Domain\Trick\CreateTrick;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateTrickDTO
{

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Le nom du trick ne doit pas être vide !"
     * )
     */
    protected $name;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="La description du trick ne doit pas être vide !"
     * )
     * @Assert\Length(
     *     min=10,
     *     minMessage="Votre description doit comporter plus de 10 caractères !"
     * )
     */
    protected $description;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Le lien de l'image du trick ne doit pas être vide !"
     * )
     * @Assert\Url(
     *     message="Le lien de l'image doit être une URL !"
     * )
     */
    protected $coverPicture;

    protected $style;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Le lien de l'image ne doit pas être vide !"
     * )
     * @Assert\Url(
     *     message="Le lien de l'image doit être une URL !"
     * )
     */
    protected $pictureLink;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="La description de l'image ne doit pas être vide !"
     * )
     */
    protected $pictureAlt;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Le lien de la vidéo ne doit pas être vide !"
     * )
     * @Assert\Url(
     *     message="Le lien de la vidéo doit être une URL !"
     * )
     */
    protected $videoLink;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getCoverPicture(): ?string
    {
        return $this->coverPicture;
    }

    /**
     * @param string $coverPicture
     */
    public function setCoverPicture(string $coverPicture): void
    {
        $this->coverPicture = $coverPicture;
    }

    /**
     * @return mixed
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param mixed $style
     */
    public function setStyle($style): void
    {
        $this->style = $style;
    }

    /**
     * @return string
     */
    public function getPictureLink(): ?string
    {
        return $this->pictureLink;
    }

    /**
     * @param string $pictureLink
     */
    public function setPictureLink(string $pictureLink): void
    {
        $this->pictureLink = $pictureLink;
    }

    /**
     * @return string
     */
    public function getPictureAlt(): ?string
    {
        return $this->pictureAlt;
    }

    /**
     * @param string $pictureAlt
     */
    public function setPictureAlt(string $pictureAlt): void
    {
        $this->pictureAlt = $pictureAlt;
    }

    /**
     * @return mixed
     */
    public function getVideoLink(): ?string
    {
        return $this->videoLink;
    }

    /**
     * @param mixed $videoLink
     */
    public function setVideoLink($videoLink): void
    {
        $this->videoLink = $videoLink;
    }
}
