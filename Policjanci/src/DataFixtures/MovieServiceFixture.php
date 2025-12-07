<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MovieServiceFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $mapping = [
            'The Human Centipede' => ['hbo'],
            'Breaking Bad' => ['netflix'],
            'Better Call Saul' => ['netflix', 'prime'],
            'Inception' => ['apple', 'prime'],
            'The Dark Knight' => ['hbo', 'apple'],
            'Interstellar' => ['prime', 'skyshowtime'],
            'The Matrix' => ['hbo', 'prime'],
            'Pulp Fiction' => ['prime', 'hbo'],
            'The Shawshank Redemption' => ['netflix', 'prime'],
            'Stranger Things' => ['netflix'],
        ];

        foreach ($mapping as $movieName => $services) {
            $movie = $this->getReference('movie_'.$movieName, Movie::class);
            foreach ($services as $serviceShortName) {
                $service = $this->getReference('service_'.$serviceShortName, Service::class);
                $movie->addService($service);
            }
            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [MovieFixture::class, ServiceFixture::class];
    }
}
