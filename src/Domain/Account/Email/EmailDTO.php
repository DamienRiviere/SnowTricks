<?php

namespace App\Domain\Account\Email;

use App\Domain\Common\Validators\UniqueEntityInput;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class EmailDTO
 * @package App\Domain\Account\Email
 * @UniqueEntityInput(
 *     class="App\Entity\User",
 *     fields={"email"},
 *     message="Cette adresse email est déjà existante, veuillez la modifier !"
 * )
 */
final class EmailDTO
{

    /**
     * @Assert\NotBlank(
     *     message = "L'email ne doit pas être vide !"
     * )
     * @Assert\Email(
     *     message = "L'email n'est pas valide !"
     * )
     */
    protected $email;

    public static function updateToDto(string $email)
    {
        $dto = new self();
        $dto->setEmail($email);

        return $dto;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }
}
