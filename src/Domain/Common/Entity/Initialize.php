<?php

namespace App\Domain\Common\Entity;

use Cocur\Slugify\Slugify;

class Initialize
{

    /**
     * Initialize slug when the trick is created
     * @param $name
     * @return string
     */
    public static function initializeSlug($name)
    {
        $slugify = new Slugify();
        return $slugify->slugify($name);
    }

    /**
     * Initialize date when the trick is created or modified
     * @param $createdAt
     * @return \Datetime
     * @throws \Exception
     */
    public static function initializeDate($createdAt)
    {
        if (empty($createdAt)) {
            return $createdAt = new \Datetime();
        }
    }
}
