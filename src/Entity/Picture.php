<?php

namespace App\Entity;

use App\Domain\Services\FileUploader;
use App\Domain\Trick\Helpers\UpdateTrick;
use App\Domain\Trick\TrickDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false, name="trick_id")
     */
    private $trick;

    /**
     * Get pictures from the dto and create a new Picture entity
     * @param TrickDTO $dto
     * @param Trick $trick
     * @param $uploadDir
     * @return array
     */
    public static function create(TrickDTO $dto, Trick $trick, string $uploadDir)
    {
        $pictures = [];

        foreach ($dto->getPictures() as $item) {
            $upload = new FileUploader($uploadDir);
            $newFilename = $upload->upload($item->getPicture());

            $picture = new self();
            $picture
                ->setPicture($newFilename)
                ->setTitle($item->getTitle())
                ->setTrick($trick);

            $pictures[] = $picture;
        }

        return $pictures;
    }

    /**
     * Edit pictures and add new pictures
     * @param TrickDTO $dto
     * @param Trick $trick
     * @param string $uploadDir
     * @return array
     */
    public static function editPictures(TrickDTO $dto, Trick $trick, string $uploadDir)
    {
        $editPictures = [];

        $pictures = UpdateTrick::getItems($trick->getPictures());
        $picturesDto = UpdateTrick::getItems($dto->getPictures());

        $newPictures = self::getNewPictures($picturesDto, $trick, $uploadDir);

        foreach ($pictures as $picture) {
            foreach ($picturesDto as $pictureDto) {
                if ($picture->getId() === $pictureDto->getId()) {
                    $upload = new FileUploader($uploadDir);
                    $newFilename = $upload->upload($pictureDto->getPicture());

                    $picture
                        ->setTitle($pictureDto->getTitle())
                        ->setPicture($newFilename);

                    $editPictures[] = $picture;
                }
            }
        }

        $editPictures = UpdateTrick::addNewItemToEditItems($newPictures, $editPictures);

        return $editPictures;
    }

    /**
     * Get new pictures from the PictureDTO and created the entity
     * @param array $pictures
     * @param Trick $trick
     * @param string $uploadDir
     * @return array
     */
    public static function getNewPictures(array $pictures, Trick $trick, string $uploadDir)
    {
        $newPictures = [];

        foreach ($pictures as $picture) {
            if ($picture->getId() === null) {
                $upload = new FileUploader($uploadDir);
                $newFilename = $upload->upload($picture->getPicture());

                $newPicture = new self();
                $newPicture
                    ->setTitle($picture->getTitle())
                    ->setPicture($newFilename)
                    ->setTrick($trick);

                $newPictures[] = $newPicture;
            }
        }

        return $newPictures;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
    
    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture): self
    {
        $this->picture = $picture;

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
