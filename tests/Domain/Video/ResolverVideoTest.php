<?php

namespace App\Tests\Domain\Video;

use App\Domain\Trick\TrickDTO;
use App\Domain\Trick\Video\ResolverVideo;
use App\Domain\Trick\Video\VideoDTO;
use App\Entity\Style;
use App\Entity\Trick;
use App\Entity\Video;
use PHPUnit\Framework\TestCase;

class ResolverVideoTest extends TestCase
{

    /** @var ResolverVideo */
    protected $resolver;

    protected function setUp(): void
    {
        $this->resolver = new ResolverVideo();
    }

    public function testCreate()
    {
        $videosDto = [];

        for ($i = 0; $i < 5; $i++) {
            $videoDto = new VideoDTO();
            $videoDto->setLink("https://www.youtube.com/watch?v=SQyTWk7OxSI");

            $videosDto[] = $videoDto;
        }

        $style = new Style();
        $style
            ->setName("Super style")
            ->setDescription("Description du super style !");


        $trick = new Trick();
        $trick
            ->setName("Premier trick")
            ->setDescription("Description du premier trick !")
            ->setStyle($style);

        $videos = $this->resolver->create($videosDto, $trick);

        $this->assertIsArray($videos);
        $this->assertNotNull($videos);

        foreach ($videos as $video) {
            $this->assertInstanceOf(Video::class, $video);
        }
    }

    public function testUpdate()
    {
        $style = new Style();
        $style
            ->setName("Super style")
            ->setDescription("Description du super style !");

        $trick = new Trick();
        $trick
            ->setName("Premier trick")
            ->setDescription("Description du premier trick !")
            ->setStyle($style);

        $videosDto = [];

        for ($i = 0; $i < 5; $i++) {
            $videoDto = new VideoDTO();
            $videoDto->setLink("https://www.youtube.com/watch?v=SQyTWk7OxSI");

            $videosDto[] = $videoDto;
        }

        $trickDto = new TrickDTO();
        $trickDto
            ->setName("Premier trick")
            ->setDescription("Description du premier trick !")
            ->setStyle($style);

        foreach ($videosDto as $videoDto) {
            $trickDto->addVideo($videoDto);
        }

        $videos = $this->resolver->update($trickDto, $trick);

        $this->assertIsArray($videos);
        $this->assertNotNull($videos);

        foreach ($videos as $video) {
            $this->assertInstanceOf(Video::class, $video);
        }
    }
}
