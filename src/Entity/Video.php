<?php

namespace App\Entity;

use App\Domain\Trick\Helpers\UpdateTrick;
use App\Domain\Trick\TrickDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="videos")
     * @ORM\JoinColumn(nullable=false, name="trick_id")
     */
    private $trick;

    /**
     * Get videos from the dto and create a new Video entity
     * @param TrickDTO $dto
     * @param Trick $trick
     * @return array
     */
    public static function addVideos(TrickDTO $dto, Trick $trick)
    {
        $videos = [];

        foreach ($dto->getVideos() as $item) {
            $video = new self();
            $video
                ->setLink($item->getLink())
                ->setTrick($trick);

            $videos[] = $video;
        }

        return $videos;
    }

    /**
     * Edit pictures and add new pictures
     * @param TrickDTO $dto
     * @param Trick $trick
     * @return array
     */
    public static function editVideos(TrickDTO $dto, Trick $trick)
    {
        $editVideos = [];

        $videos = UpdateTrick::getItems($trick->getVideos());
        $videosDto = UpdateTrick::getItems($dto->getVideos());
        $newVideos = self::getNewVideos($videosDto, $trick);

        foreach ($videos as $video) {
            foreach ($videosDto as $videoDto) {
                if ($video->getId() === $videoDto->getId()) {
                    $video
                        ->setLink($videoDto->getLink());

                    $editVideos[] = $video;
                }
            }
        }

        $editVideos = UpdateTrick::addNewItemToEditItems($newVideos, $editVideos);

        return $editVideos;
    }

    /**
     * Get all videos to create when the form is edited
     * @param array $videos
     * @param Trick $trick
     * @return array
     */
    public static function getNewVideos(array $videos, Trick $trick)
    {
        $newVideos = [];

        foreach ($videos as $video) {
            if ($video->getId() === null) {
                $newVideo = new self();
                $newVideo
                    ->setLink($video->getLink())
                    ->setTrick($trick);

                $newVideos[] = $newVideo;
            }
        }

        return $newVideos;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
