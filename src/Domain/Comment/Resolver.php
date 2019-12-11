<?php

namespace App\Domain\Comment;

use App\Entity\Comment;
use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

final class Resolver
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var Security */
    protected $security;

    /** @var EntityManagerInterface */
    protected $em;

    public function __construct(FormFactoryInterface $formFactory, Security $security, EntityManagerInterface $em)
    {
        $this->formFactory = $formFactory;
        $this->security = $security;
        $this->em = $em;
    }

    public function getFormType(Request $request): FormInterface
    {
        return $this->formFactory->create(CommentType::class)
                                 ->handleRequest($request);
    }

    public function save(CommentDTO $dto, Trick $trick)
    {
        $comment = Comment::create($dto, $trick, $this->security);

        $this->em->persist($comment);
        $this->em->flush();
    }
}
