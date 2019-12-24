<?php

namespace App\Tests\Domain\Picture;

use App\Domain\Services\FileUploader;
use App\Domain\Trick\Picture\PictureDTO;
use App\Domain\Trick\Picture\ResolverPicture;
use App\Entity\Style;
use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Security;

class ResolverPictureTest extends WebTestCase
{

    /** @var ResolverPicture */
    protected $resolver;

    /** @var FileUploader */
    protected $upload;

    /** @var Security */
    protected $mockSecurity;

    protected $uploadDirTrick;

    protected $file;
    protected $image;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->uploadDirTrick = self::$container->getParameter("upload_dir_trick");
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

        for ($i = 0; $i < 5; $i++) {
            $file = tempnam(sys_get_temp_dir(), 'upl');
            imagepng(imagecreatetruecolor(10, 10), $file); // create and write image/png to it

            $pictureDto = new PictureDTO();
            $pictureDto
                ->setPicture(new UploadedFile(
                    $file,
                    'new_image.png'
                ))
                ->setTitle("Image 1");

            $picturesDto[] = $pictureDto;
        }

        $pictures = $this->resolver->create($picturesDto, $trick);

        $this->assertIsArray($pictures);
        $this->assertNotNull($pictures);
    }

//    public function testUpdate()
//    {
//        $style = new Style();
//        $style
//            ->setName("Mon super style")
//            ->setDescription("Ma super description de style");
//
//        $trick = new Trick();
//        $trick
//            ->setName("Mon premier trick !")
//            ->setDescription("Description du premier trick")
//            ->setStyle($style)
//            ->setUser($this->mockSecurity->getUser());
//
//        $picturesDto = [];
//
//        for ($i = 0; $i < 5; $i++) {
//            $pictureDto = new PictureDTO();
//            $pictureDto
//                ->setPicture(new UploadedFile(
//                    "path/to/photo.jpg",
//                    "photo.jpg",
//                    "image/jpg"
//                ))
//                ->setTitle("Image 1");
//
//            $picturesDto[] = $pictureDto;
//        }
//
//        $this->assertIsArray($picturesDto);
//        $this->assertNotNull($picturesDto);
//    }
}
