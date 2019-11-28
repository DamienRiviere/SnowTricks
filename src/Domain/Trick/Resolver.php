<?php

namespace App\Domain\Trick;

use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class Resolver
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var EntityManagerInterface */
    protected $em;

	/**
	 * Resolver constructor.
	 * @param FormFactoryInterface $formFactory
	 * @param EntityManagerInterface $em
	 */
    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $em)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
    }

    public function getFormType(Request $request)
    {
        return $this->formFactory->create(TrickType::class)
                                 ->handleRequest($request);
    }

    public function save(TrickDTO $dto)
    {
        $trick = Trick::create($dto);
        $pictures = Picture::create($dto, $trick);
        $videos = Video::create($dto, $trick);

        $this->em->persist($trick);
        $this->savePicture($pictures);
        $this->saveVideo($videos);

        $this->em->flush();
    }

    public function savePicture(array $pictures)
    {
        foreach ($pictures as $picture) {
            $this->em->persist($picture);
        }
    }

    public function saveVideo(array $videos)
    {
        foreach ($videos as $video) {
            $this->em->persist($video);
        }
    }
}
