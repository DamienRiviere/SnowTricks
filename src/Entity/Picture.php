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
            $originFilename = pathinfo($item->getPicture()->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate(
                'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
                $originFilename
            );
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $item->getPicture()->guessExtension();
            $item->getPicture()->move(
                $uploadDir,
                $newFilename
            );

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

    public function setPicture(string $picture): self
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
