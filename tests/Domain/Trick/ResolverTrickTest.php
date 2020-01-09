<?php

namespace App\Tests\Domain\Trick;

use App\Domain\Helpers\ResolverHelper;
use App\Domain\Trick\Picture\ResolverPicture;
use App\Domain\Trick\ResolverTrick;
use App\Domain\Trick\TrickDTO;
use App\Domain\Trick\Video\ResolverVideo;
use App\Entity\Style;
use App\Entity\Trick;
use App\Entity\TrickLike;
use App\Repository\PictureRepository;
use App\Repository\TrickLikeRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Security;

class ResolverTrickTest extends TestCase
{

    /** @var ResolverTrick */
    protected $resolver;

    /** @var FormFactoryInterface */
    protected $mockFormFactory;

    /** @var Security */
    protected $mockSecurity;

    /** @var TrickLikeRepository */
    protected $mockLikeRepo;

    /** @var FlashBagInterface */
    protected $mockFlash;

    protected function setUp(): void
    {
        $this->mockFormFactory = $this->createMock(FormFactoryInterface::class);
        $mockEm = $this->createMock(EntityManagerInterface::class);
        $mockTrickRepo = $this->createMock(TrickRepository::class);
        $mockPictureRepo = $this->createMock(PictureRepository::class);
        $mockVideoRepo = $this->createMock(VideoRepository::class);
        $mockHelper = $this->createMock(ResolverHelper::class);
        $this->mockSecurity = $this->createMock(Security::class);
        $mockResolverPicture = $this->createMock(ResolverPicture::class);
        $mockResolverVideo = $this->createMock(ResolverVideo::class);
        $this->mockLikeRepo = $this->createMock(TrickLikeRepository::class);
        $this->mockFlash = $this->createMock(FlashBagInterface::class);

        $this->resolver = new ResolverTrick(
            $this->mockFormFactory,
            $mockEm,
            $mockTrickRepo,
            $mockPictureRepo,
            $mockVideoRepo,
            $mockHelper,
            $this->mockSecurity,
            $mockResolverPicture,
            $mockResolverVideo,
            $this->mockLikeRepo,
            $this->mockFlash
        );
    }

    public function testCreateTrick()
    {
        $style = new Style();
        $style
            ->setName("Mon super style")
            ->setDescription("Ma super description de style");

        $dto = new TrickDTO();
        $dto->setName("Damien")
            ->setDescription("Ma superbe description !")
            ->setStyle($style);

        $this->assertInstanceOf(Trick::class, $this->resolver->createTrick($dto, $this->mockSecurity));
    }

    public function testUpdateTrick()
    {
        $style = new Style();
        $style
            ->setName("Mon super style")
            ->setDescription("Ma super description de style");

        $dto = new TrickDTO();
        $dto->setName("Damien")
            ->setDescription("Ma superbe description !")
            ->setStyle($style);

        $this->assertInstanceOf(Trick::class, $this->resolver->createTrick($dto, $this->mockSecurity));
    }

    public function testLike()
    {
        $style = new Style();
        $style
            ->setName("Mon super style")
            ->setDescription("Ma super description de style");

        $trick = new Trick();
        $trick
            ->setName("Mon premier trick !")
            ->setDescription("Description du premier trick")
            ->setStyle($style)
            ->setUser($this->mockSecurity->getUser());

        $like = new TrickLike();
        $like
            ->setTrick($trick)
            ->setUser($this->mockSecurity->getUser());

        $this->assertInstanceOf(TrickLike::class, $like);
    }
}
