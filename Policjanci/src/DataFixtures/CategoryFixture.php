<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = ['Horror', 'Drama', 'Crime', 'Thriller', 'Comedy', 'Sci-Fi', 'Action', 'Series'];

        foreach ($categories as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);

            $this->addReference('category_'.$name, $category);
        }

        $manager->flush();
    }
}
