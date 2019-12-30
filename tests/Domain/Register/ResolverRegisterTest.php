<?php

namespace App\Tests\Domain\Register;

use App\Domain\Register\RegisterDTO;
use App\Domain\Register\ResolverRegister;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResolverRegisterTest extends TestCase
{

    /** @var ResolverRegister */
    protected $resolver;

    /** @var UserPasswordEncoderInterface */
    protected $mockEncoder;

    protected function setUp()
    {
        $mockFormFactory = $this->createMock(FormFactoryInterface::class);
        $mockEm = $this->createMock(EntityManagerInterface::class);
        $this->mockEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $this->mockEncoder->method("encodePassword")->willReturn("toto");
        $mockFlash = $this->createMock(FlashBagInterface::class);
        $this->resolver = new ResolverRegister(
            $mockFormFactory,
            $mockEm,
            $this->mockEncoder,
            $mockFlash
        );
    }

    public function testCreate()
    {
        $registerDto = new RegisterDTO();
        $registerDto->setName("Damien");
        $registerDto->setEmail("damien@gmail.fr");
        $registerDto->setPassword("test");

        $user = $this->resolver->create($registerDto);

        $this->assertInstanceOf(User::class, $user);
    }
}
