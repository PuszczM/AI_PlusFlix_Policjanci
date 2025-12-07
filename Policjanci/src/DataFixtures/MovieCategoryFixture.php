<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MovieCategoryFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $mapping = [
            'The Human Centipede' => ['Horror', 'Thriller'],
            'Breaking Bad' => ['Drama', 'Crime', 'Series'],
            'Better Call Saul' => ['Drama', 'Crime', 'Series'],
            'Inception' => ['Sci-Fi', 'Action', 'Thriller'],
            'The Dark Knight' => ['Action', 'Crime', 'Drama'],
            'Interstellar' => ['Sci-Fi', 'Drama'],
            'The Matrix' => ['Sci-Fi', 'Action'],
            'Pulp Fiction' => ['Crime', 'Drama'],
            'The Shawshank Redemption' => ['Drama'],
            'Stranger Things' => ['Series', 'Sci-Fi', 'Thriller'],
        ];

        foreach ($mapping as $movieName => $categories) {
            $movie = $this->getReference('movie_'.$movieName, Movie::class);
            foreach ($categories as $categoryName) {
                $category = $this->getReference('category_'.$categoryName, Category::class);
                $movie->addCategory($category);
            }
            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
            MovieFixture::class,
        ];
    }
}
