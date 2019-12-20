<?php

namespace App\Tests\Domain\Account\Email;

use App\Domain\Account\Email\EmailDTO;
use App\Domain\Account\Email\ResolverEmail;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ResolverEmailTest extends TestCase
{

    /** @var ResolverEmail */
    protected $resolver;

    protected function setUp()
    {
        $mockFormFactory = $this->createMock(FormFactoryInterface::class);
        $mockEm = $this->createMock(EntityManagerInterface::class);
        $mockFlash = $this->createMock(FlashBagInterface::class);

        $this->resolver = new ResolverEmail($mockFormFactory, $mockEm, $mockFlash);
    }

    public function testUpdateEmail()
    {
        $emailDto = new EmailDTO();
        $emailDto->setEmail("mail@gmail.com");

        $user = new User();
        $user
            ->setName("Damien")
            ->setEmail("test@hotmail.com")
            ->setPicture("photo.jpg")
            ->setPassword("mdp");

        $user = $this->resolver->updateEmail($emailDto, $user);
        $this->assertIsString($user->getEmail());
        $this->assertNotNull($user->getEmail());
        $this->assertInstanceOf(User::class, $user);
    }
}
