<?php

namespace App\Domain\Recovery;

use Symfony\Component\Validator\Constraints as Assert;

final class PasswordDTO
{

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Le mot de passe ne doit pas être vide !"
     * )
     * @Assert\Length(
     *     min="4",
     *     minMessage="Le mot de passe doit comporter au minimum 4 caractères !"
     * )
     */
    protected $password;

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }
}
