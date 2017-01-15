<?php

namespace Tests\Archetype\DemoBundle\MotherObjects;

use Archetype\DemoBundle\Entity\Category;

class CategoryMotherObject
{
    const NAME = 'name';

    public static function create()
    {
        $category = new Category();
        $category->setName(self::NAME);

        return $category;
    }
}
