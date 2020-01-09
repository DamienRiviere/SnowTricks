<?php

namespace App\Domain\Recovery;

use Symfony\Component\Validator\Constraints as Assert;

final class SendEmailDTO
{

    /**
     * @Assert\NotBlank(
     *      message="L'email ne doit pas être vide !"
     * )
     * @Assert\Email(
     *     message="L'email doit être au bon format !"
     * )
     */
    protected $email;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
