<?php

namespace App\Domain\Trick\Picture;

use App\Domain\Services\FileUploader;
use App\Domain\Trick\Helpers\UpdateTrick;
use App\Domain\Trick\TrickDTO;
use App\Entity\Picture;
use App\Entity\Trick;

final class ResolverPicture
{

    protected $uploadDirTrick;

    /** @var FileUploader */
    protected $upload;

    public function __construct(string $uploadDirTrick)
    {
        $this->uploadDirTrick = $uploadDirTrick;
        $this->upload = new FileUploader($this->uploadDirTrick);
    }

    /**
     * Get pictures from the dto and create a new Picture entity
     * @param array $picturesDto
     * @param Trick $trick
     * @return array
     */
    public function create(array $picturesDto, Trick $trick)
    {
        $pictures = [];

        foreach ($picturesDto as $pictureDto) {
            $newFilename = $this->upload->upload($pictureDto->getPicture());

            $picture = new Picture();
            $picture
                ->setPicture($newFilename)
                ->setTitle($pictureDto->getTitle())
                ->setTrick($trick);

            $pictures[] = $picture;
        }

        return $pictures;
    }

    /**
     * Update pictures and add new pictures
     * @param TrickDTO $dto
     * @param Trick $trick
     * @return array
     */
    public function update(TrickDTO $dto, Trick $trick)
    {
        $updatePictures = [];

        $pictures = UpdateTrick::getItems($trick->getPictures());
        $picturesDto = $dto->getPictures();
        $newPictures = $this->createOnUpdate($picturesDto, $trick);
        $this->deleteOnUpdate($picturesDto, $pictures);

        foreach ($pictures as $picture) {
            foreach ($picturesDto as $pictureDto) {
                if ($pictureDto->getPicture() != null && $picture->getId() === $pictureDto->getId()) {
                    $newFilename = $this->upload->upload($pictureDto->getPicture());

                    $picture
                        ->setTitle($pictureDto->getTitle())
                        ->setPicture($newFilename);

                    $updatePictures[] = $picture;
                }
            }
        }

        $updatePictures = UpdateTrick::addNewItemToUpdateItems($newPictures, $updatePictures);

        return $updatePictures;
    }

    /**
     * Get new pictures from the PictureDTO and created the entity
     * @param array $pictures
     * @param Trick $trick
     * @return array
     */
    public function createOnUpdate(array $pictures, Trick $trick)
    {
        $picturesDto = UpdateTrick::searchById(null, $pictures);
        return $this->create($picturesDto, $trick);
    }

    /**
     * Delete picture file if she is updated
     * @param array $picturesDto
     * @param array $pictures
     */
    public function deleteOnUpdate(array $picturesDto, array $pictures)
    {
        foreach ($picturesDto as $pictureDto) {
            foreach ($pictures as $picture) {
                if ($pictureDto->getPicture() != null && $pictureDto->getId() === $picture->getId()) {
                    unlink("uploads/trick/" . $picture->getPicture());
                }
            }
        }
    }

    /**
     * Delete files if they are deleted from trick
     * @param $path
     * @param $pictures
     */
    public function deleteFiles($path, $pictures)
    {
        foreach ($pictures as $picture) {
            unlink($path . $picture->getPicture());
        }
    }
}
