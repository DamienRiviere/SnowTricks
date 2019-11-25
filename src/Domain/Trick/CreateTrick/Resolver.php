<?php

namespace App\Domain\Trick\CreateTrick;

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
        return $this->formFactory->create(CreateTrickType::class)
                                 ->handleRequest($request);
    }

    public function save(CreateTrickDTO $dto)
    {
        $trick = Trick::create($dto);
        $picture = Picture::create($dto, $trick);
        $video = Video::create($dto, $trick);

        $this->em->persist($trick);
        $this->em->persist($picture);
        $this->em->persist($video);

        $this->em->flush();
    }
}
