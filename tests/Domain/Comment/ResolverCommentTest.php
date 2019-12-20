<?php

namespace App\Tests\Domain\Comment;

use App\Domain\Comment\CommentDTO;
use App\Domain\Comment\ResolverComment;
use App\Domain\Trick\ResolverTrick;
use App\Entity\Comment;
use App\Entity\Style;
use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Security;

class ResolverCommentTest extends TestCase
{

    /** @var ResolverTrick */
    protected $resolver;

    /** @var FormFactoryInterface */
    protected $mockFormFactory;

    /** @var Security */
    protected $mockSecurity;

    /** @var EntityManagerInterface */
    protected $mockEm;

    protected function setUp(): void
    {
        $this->mockFormFactory = $this->createMock(FormFactoryInterface::class);
        $this->mockSecurity = $this->createMock(Security::class);
        $this->mockEm = $this->createMock(EntityManagerInterface::class);

        $this->resolver = new ResolverComment(
            $this->mockFormFactory,
            $this->mockSecurity,
            $this->mockEm
        );
    }

    public function testCreate()
    {
        $commentDto = new CommentDTO();
        $commentDto
            ->setContent("Mon magnifique commentaire !");

        $style = new Style();
        $style
            ->setName("Super style !")
            ->setDescription("Description du super style !");

        $trick = new Trick();
        $trick
            ->setName("Premier trick !")
            ->setDescription("Description du premier trick !")
            ->setStyle($style);

        $comment = $this->resolver->create($commentDto, $trick, $this->mockSecurity);

        $this->assertNotNull($comment);
        $this->assertIsString($comment->getContent());
        $this->assertInstanceOf(Comment::class, $comment);
    }
}
