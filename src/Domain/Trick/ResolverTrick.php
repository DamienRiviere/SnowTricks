<?php

namespace App\Domain\Trick;

use App\Domain\Helpers\ResolverHelper;
use App\Domain\Trick\Helpers\UpdateTrick;
use App\Domain\Trick\Picture\ResolverPicture;
use App\Domain\Trick\Video\ResolverVideo;
use App\Entity\Trick;
use App\Repository\PictureRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

final class ResolverTrick
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

    /** @var \Security */
    protected $security;

    /** @var ResolverPicture */
    protected $resolverPicture;

    /** @var ResolverVideo */
    protected $resolverVideo;

    /**
     * ResolverTrick constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $em
     * @param TrickRepository $trickRepo
     * @param PictureRepository $pictureRepo
     * @param VideoRepository $videoRepository
     * @param ResolverHelper $helper
     * @param Security $security
     * @param ResolverPicture $resolverPicture
     * @param ResolverVideo $resolverVideo
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $em,
        TrickRepository $trickRepo,
        PictureRepository $pictureRepo,
        VideoRepository $videoRepository,
        ResolverHelper $helper,
        Security $security,
        ResolverPicture $resolverPicture,
        ResolverVideo $resolverVideo
    ) {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->trickRepo = $trickRepo;
        $this->pictureRepo = $pictureRepo;
        $this->videoRepo = $videoRepository;
        $this->helper = $helper;
        $this->security = $security;
        $this->resolverPicture = $resolverPicture;
        $this->resolverVideo = $resolverVideo;
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
     * @return Trick
     */
    public function save(TrickDTO $dto)
    {
        $trick = Trick::create($dto, $this->security);
        $pictures = $this->resolverPicture->create($dto->getPictures(), $trick);
        $videos = $this->resolverVideo->create($dto->getVideos(), $trick);

        $this->em->persist($trick);
        $this->helper->saveItems($pictures);
        $this->helper->saveItems($videos);

        $this->em->flush();

        return $trick;
    }

    /**
     * Update the trick
     * @param TrickDTO $dto
     * @param Trick $trick
     * @return Trick
     */
    public function update(TrickDTO $dto, Trick $trick)
    {
        $trick = Trick::create($dto, $this->security, $trick);
        $updatePictures = $this->resolverPicture->update($dto, $trick);

        // Contains pictures to remove from database
        $picturesToRemove = UpdateTrick::getItemsToRemove($dto->getPictures(), $trick->getPictures());
        // File to remove in uploads/trick directory
        $this->resolverPicture->deleteFiles("uploads/trick/", $picturesToRemove);

        $updateVideos = $this->resolverVideo->update($dto, $trick);
        $videosToRemove = UpdateTrick::getItemsToRemove($dto->getVideos(), $trick->getVideos());

        $this->em->persist($trick);
        $this->helper->saveItems($updatePictures);
        $this->helper->saveItems($updateVideos);
        $this->helper->checkIfNotEmptyAndRemove($videosToRemove);
        $this->helper->checkIfNotEmptyAndRemove($picturesToRemove);

        $this->em->flush();

        return $trick;
    }
}
