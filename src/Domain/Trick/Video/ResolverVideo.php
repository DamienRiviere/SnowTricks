<?php

namespace App\Domain\Trick\Video;

use App\Domain\Trick\Helpers\UpdateTrick;
use App\Domain\Trick\TrickDTO;
use App\Entity\Trick;
use App\Entity\Video;

final class ResolverVideo
{

    /**
     * Get videos from the dto and create a new Video entity
     * @param array $videosDto
     * @param Trick $trick
     * @return array
     */
    public function create(array $videosDto, Trick $trick)
    {
        $videos = [];

        foreach ($videosDto as $videoDto) {
            $video = new Video();
            $video
                ->setLink($videoDto->getLink())
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
    public function update(TrickDTO $dto, Trick $trick)
    {
        $updateVideos = [];

        $videos = UpdateTrick::getItems($trick->getVideos());
        $videosDto = $dto->getVideos();
        $newVideos = self::createOnUpdate($videosDto, $trick);

        foreach ($videos as $video) {
            foreach ($videosDto as $videoDto) {
                if ($video->getId() === $videoDto->getId()) {
                    $video
                        ->setLink($videoDto->getLink());

                    $updateVideos[] = $video;
                }
            }
        }

        $updateVideos = UpdateTrick::addNewItemToUpdateItems($newVideos, $updateVideos);

        return $updateVideos;
    }

    /**
     * Get new videos from the VideoDTO and created the entity
     * @param array $videos
     * @param Trick $trick
     * @return array
     */
    public function createOnUpdate(array $videos, Trick $trick)
    {
        $videosDto = UpdateTrick::searchById(null, $videos);
        return $this->create($videosDto, $trick);
    }
}
