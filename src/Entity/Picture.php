<?php

namespace App\Entity;

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
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false, name="trick_id")
     */
    private $trick;

    /**
     * Get pictures from the dto and create a new Picture entity
     * @param TrickDTO $dto
     * @param Trick $trick
     * @return array
     */
    public static function addPictures(TrickDTO $dto, Trick $trick)
    {
        $pictures = [];

        foreach ($dto->getPictures() as $item) {
            $picture = new self();
            $picture
                ->setLink($item->getLink())
                ->setAlt($item->getAlt())
                ->setTrick($trick);

            $pictures[] = $picture;
        }

        return $pictures;
    }

    /**
     * Edit pictures and add new pictures
     * @param TrickDTO $dto
     * @param Trick $trick
     * @return array
     */
    public static function editPictures(TrickDTO $dto, Trick $trick)
    {
        $editPictures = [];

        $pictures = UpdateTrick::getItems($trick->getPictures());
        $picturesDto = UpdateTrick::getItems($dto->getPictures());

        $newPictures = self::getNewPictures($picturesDto, $trick);

        foreach ($pictures as $picture) {
            foreach ($picturesDto as $pictureDto) {
                if ($picture->getId() === $pictureDto->getId()) {
                    $picture
                        ->setLink($pictureDto->getLink())
                        ->setAlt($pictureDto->getAlt());

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
     * @return array
     */
    public static function getNewPictures(array $pictures, Trick $trick)
    {
        $newPictures = [];

        foreach ($pictures as $picture) {
            if ($picture->getId() === null) {
                $newPicture = new self();
                $newPicture
                    ->setLink($picture->getLink())
                    ->setAlt($picture->getAlt())
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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;

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
