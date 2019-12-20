<?php

namespace App\Tests\Domain\Picture;

use App\Domain\Services\FileUploader;
use App\Domain\Trick\Picture\PictureDTO;
use App\Domain\Trick\Picture\ResolverPicture;
use App\Entity\Style;
use App\Entity\Trick;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Security;

class ResolverPictureTest extends TestCase
{

    /** @var ResolverPicture */
    protected $resolver;

    /** @var FileUploader */
    protected $upload;

    /** @var Security */
    protected $mockSecurity;

    protected $uploadDirTrick;

    public function __construct(string $uploadDirTrick)
    {
        parent::__construct();
        $this->uploadDirTrick = $uploadDirTrick;
    }

    protected function setUp(): void
    {
        $this->mockSecurity = $this->createMock(Security::class);
        $this->resolver = new ResolverPicture($this->uploadDirTrick);
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

        dd($this->uploadDirTrick);

        for ($i = 0; $i < 5; $i++) {
            $pictureDto = new PictureDTO();
            $pictureDto
                ->setPicture(new UploadedFile(
                    "path/to/photo.jpg",
                    "photo.jpg",
                    "image/jpg"
                ))
                ->setTitle("Image 1");

            $picturesDto[] = $pictureDto;
        }

        $pictures = $this->resolver->create($picturesDto, $trick);

        $this->assertIsArray($pictures);
        $this->assertNotNull($pictures);
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

        $picturesDto = [];

        for ($i = 0; $i < 5; $i++) {
            $pictureDto = new PictureDTO();
            $pictureDto
                ->setPicture(new UploadedFile(
                    "path/to/photo.jpg",
                    "photo.jpg",
                    "image/jpg"
                ))
                ->setTitle("Image 1");

            $picturesDto[] = $pictureDto;
        }

        $this->assertIsArray($picturesDto);
        $this->assertNotNull($picturesDto);
    }
}
