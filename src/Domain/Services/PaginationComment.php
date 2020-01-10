<?php

namespace App\Domain\Services;

use App\Entity\Comment;
use App\Entity\Trick;

final class PaginationComment
{

    public function getOffset(int $page): int
    {
        return is_null($page) || (int) $page === 1 ? 0 : ((int) $page - 1) * Comment::LIMIT_PER_PAGE;
    }

    public function getPages(Trick $trick): int
    {
        $comments = $trick->getComments();
        $total = count($comments);

        return ceil($total / Comment::LIMIT_PER_PAGE);
    }
}
