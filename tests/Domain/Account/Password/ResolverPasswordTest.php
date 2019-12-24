<?php

namespace App\Tests\Domain\Account\Password;

use App\Domain\Account\Password\PasswordDTO;
use App\Domain\Account\Password\ResolverPassword;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResolverPasswordTest extends TestCase
{

    /** @var ResolverPassword */
    protected $resolver;

    /** @var UserPasswordEncoderInterface */
    protected $mockEncoder;

    protected function setUp()
    {
        $mockFormFactory = $this->createMock(FormFactoryInterface::class);
        $mockEm = $this->createMock(EntityManagerInterface::class);
        $mockFlash = $this->createMock(FlashBagInterface::class);
        $this->mockEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $this->mockEncoder->method("encodePassword")->willReturn("toto");

        $this->resolver = new ResolverPassword(
            $mockFormFactory,
            $this->mockEncoder,
            $mockEm,
            $mockFlash
        );
    }

    public function testUpdatePassword()
    {
        $passwordDto = new PasswordDTO();
        $passwordDto->setPassword("monmotdepasse");

        $newUser = new User();
        $newUser
            ->setName("Damien")
            ->setEmail("test@hotmail.com")
            ->setPicture("photo.jpg")
            ->setPassword("tata");

        $user = $this->resolver->updatePassword($passwordDto, $newUser);

        $this->assertIsString($user->getPassword());
        $this->assertNotNull($user->getPassword());
        $this->assertInstanceOf(User::class, $user);
    }
}
