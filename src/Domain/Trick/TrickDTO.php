<?php

namespace App\Domain\Trick;

use Symfony\Component\Validator\Constraints as Assert;

final class TrickDTO
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
    
    protected $style;

    /**
     * @Assert\Valid()
     */
    protected $pictures;

    /**
     * @Assert\Valid()
     */
    protected $videos;

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
     * @return mixed
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @param mixed $pictures
     */
    public function setPictures($pictures): void
    {
        $this->pictures = $pictures;
    }

    /**
     * @return mixed
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param mixed $videos
     */
    public function setVideos($videos): void
    {
        $this->videos = $videos;
    }
}
