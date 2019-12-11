<?php

namespace App\Domain\Comment;

use Symfony\Component\Validator\Constraints as Assert;

final class CommentDTO
{


    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "Veuillez écrire un commentaire !"
     * )
     */
    protected $content;

    /**
     * @return mixed
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
