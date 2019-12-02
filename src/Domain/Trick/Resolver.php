<?php

namespace App\Domain\Trick;

use App\Domain\Helpers\ResolverHelper;
use App\Domain\Trick\Helpers\UpdateTrick;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\Video;
use App\Repository\PictureRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

final class Resolver
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var TrickRepository */
    protected $trickRepo;

    /** @var PictureRepository */
    protected $pictureRepo;

    /** @var VideoRepository */
    protected $videoRepo;

    /** @var ResolverHelper */
    protected $helper;

    /**
     * Resolver constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $em
     * @param TrickRepository $trickRepo
     * @param PictureRepository $pictureRepo
     * @param VideoRepository $videoRepository
     * @param ResolverHelper $helper
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $em,
        TrickRepository $trickRepo,
        PictureRepository $pictureRepo,
        VideoRepository $videoRepository,
        ResolverHelper $helper
    ) {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->trickRepo = $trickRepo;
        $this->pictureRepo = $pictureRepo;
        $this->videoRepo = $videoRepository;
        $this->helper = $helper;
    }

    /**
     * Display the form for new trick and edit trick
     * @param Request $request
     * @param null $trick
     * @return FormInterface
     */
    public function getFormType(Request $request, $trick = null): FormInterface
    {
        $trickDto = null;
        if ($request->attributes->get('slug')) {
            $trickDto = TrickDTO::updateToDto($trick);
        }
        return $this->formFactory->create(TrickType::class, $trickDto)
                                 ->handleRequest($request);
    }

    /**
     * Save the data from new trick in database
     * @param TrickDTO $dto
     */
    public function save(TrickDTO $dto)
    {
        $trick = Trick::create($dto);
        $pictures = Picture::addPictures($dto, $trick);
        $videos = Video::addVideos($dto, $trick);

        $this->em->persist($trick);
        $this->helper->saveItems($pictures);
        $this->helper->saveItems($videos);

        $this->em->flush();
    }

    /**
     * Update the trick
     * @param TrickDTO $dto
     * @param Trick $trick
     */
    public function update(TrickDTO $dto, Trick $trick)
    {
        $trick = Trick::create($dto, $trick);
        $editPictures = Picture::editPictures($dto, $trick);
        $picturesToRemove = UpdateTrick::getItemsToRemove($dto->getPictures(), $trick->getPictures());
        $editVideos = Video::editVideos($dto, $trick);
        $videosToRemove = UpdateTrick::getItemsToRemove($dto->getVideos(), $trick->getVideos());

        $this->em->persist($trick);
        $this->helper->saveItems($editPictures);
        $this->helper->saveItems($editVideos);
        $this->helper->checkIfNotEmptyAndRemove($videosToRemove);
        $this->helper->checkIfNotEmptyAndRemove($picturesToRemove);

        $this->em->flush();
    }
}
