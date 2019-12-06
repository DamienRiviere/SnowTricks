<?php

namespace App\Domain\Register;

use App\Domain\Common\Validators\UniqueEntityInput;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegisterDTO
 * @package App\Domain\Register
 * @UniqueEntityInput(
 *     class="App\Entity\User",
 *     fields={"name", "email"},
 *     message="Ce compte est déjà existant, veuillez changer les identifiants !"
 * )
 */
final class RegisterDTO
{

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="Le nom ne doit pas être vide !"
     * )
     * @Assert\Length(
     *     min="3",
     *     minMessage="Le nom doit comporter au minimum 3 caractères"
     * )
     */
    protected $name;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message="L'email ne doit pas être vide !"
     * )
     * @Assert\Email(
     *     message="L'email doit être au bon format !"
     * )
     */
    protected $email;

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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }
}
