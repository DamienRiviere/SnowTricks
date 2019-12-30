<?php

namespace App\Tests\Domain\Picture;

use App\Domain\Trick\Picture\PictureDTO;
use App\Domain\Trick\Picture\ResolverPicture;
use App\Domain\Trick\TrickDTO;
use App\Entity\Style;
use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Security;

class ResolverPictureTest extends WebTestCase
{

    /** @var ResolverPicture */
    protected $resolver;

    /** @var Security */
    protected $mockSecurity;

    protected $uploadDirTrick;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->uploadDirTrick = self::$container->getParameter("upload_dir_trick");
        $this->mockSecurity = $this->createMock(Security::class);
    }

    public function testCreate()
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

        $picturesDto = [];

        for ($i = 0; $i < 5; $i++) {
            $pictureDto = new PictureDTO();
            $pictureDto
                ->setPicture("picture.jpg")
                ->setTitle("Image 1");

            $picturesDto[] = $pictureDto;
        }

        $this->assertIsArray($picturesDto);
        $this->assertNotNull($picturesDto);
    }

    public function testUpdate()
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

        $trickDto = new TrickDTO();
        $trickDto
            ->setName("Mon deuxième trick")
            ->setDescription("Description update du trick !")
            ->setStyle($style);

        $picturesDto = [];

        for ($i = 0; $i < 5; $i++) {
            $pictureDto = new PictureDTO();
            $pictureDto
                ->setPicture("picture.jpg")
                ->setTitle("Image 1");

            $trickDto->addPicture($pictureDto);
        }

        $this->assertIsArray($picturesDto);
        $this->assertNotNull($picturesDto);
    }
}
