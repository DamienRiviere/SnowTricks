<?php

namespace App\Tests\Domain\Authentication\Login;

use App\Domain\Authentication\Login\LoginAuthenticator;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginAuthenticatorTest extends TestCase
{

    /** @var LoginAuthenticator */
    protected $loginAuth;

    /** @var Request */
    protected $mockRequest;

    /** @var FormFactoryInterface */
    protected $mockFormFactory;

    /** @var UserRepository */
    protected $mockUserRepo;

    /** @var UserPasswordEncoderInterface */
    protected $mockEncoder;

    /** @var UrlGeneratorInterface */
    protected $mockUrlGenerator;

    /** @var SessionInterface */
    protected $mockSession;

    protected function setUp()
    {
        $this->mockRequest = $this->createMock(Request::class);
        $this->mockFormFactory = $this->createMock(FormFactoryInterface::class);
        $this->mockUserRepo = $this->createMock(UserRepository::class);
        $this->mockEncoder = $this->createMock(UserPasswordEncoderInterface::class);
        $this->mockUrlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $this->mockSession = $this->createMock(SessionInterface::class);

        $this->loginAuth = new LoginAuthenticator(
            $this->mockFormFactory,
            $this->mockUserRepo,
            $this->mockEncoder,
            $this->mockUrlGenerator,
            $this->mockSession
        );
    }

    public function testSupports()
    {
        $this->assertIsBool($this->loginAuth->supports($this->mockRequest));
    }
}
