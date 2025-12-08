<?php

namespace App\DataFixtures;

use App\Entity\Review;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReviewFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $reviews = [
            ['Breaking Bad', true, 'Walter White cooked Heisenburger.'],
            ['Breaking Bad', true, 'Vravo Bince!'],

            ['Better Call Saul', true, 'I would let Saul Goodman represent me even if I was guilty. Especially if I was guilty.'],
            ['Better Call Saul', true, 'Best CRIMINAL lawyer ever'],

            ['The Matrix', true, 'The Matrix is the most accidentally-trans-then-intentionally-trans masterpiece ever. Slay, Neo!'],
            ['The Matrix', true, 'This movie invented red pills BEFORE the internet ruined the metaphor'],

            ['The Dark Knight', true, 'We live in a society% world record attempt.'],
            ['The Dark Knight', false, 'I tried to become the Joker after watching this. Did not work. Landlord still wants rent...'],

            ['Inception', true, 'Was dreaming that I understood the plot. Woke up confused again 10/10'],

            ['Interstellar', true, 'Cried at the bookshelf scene'],
            ['Interstellar', false, 'No amogus :('],

            ['Pulp Fiction', false, 'I did not watch this'],

            ['Stranger Things', true, 'Kids fighting monsters while adults argue. Peak parenting.'],
            ['Stranger Things', false, 'Ohio irl is better'],

            ['The Human Centipede', false, 'I wish I could uninstall this movie from my brain'],
            ['The Human Centipede', false, 'Woke'],
        ];

        $counters = [];

        foreach ($reviews as [$movieName, $isPositive, $comment]) {
            /** @var Movie $movie */
            $movie = $this->getReference('movie_'.$movieName, Movie::class);

            $id = $movie->getId();
            if (!isset($counters[$id])) {
                $counters[$id] = [
                    'movie' => $movie,
                    'positive' => 0,
                    'all' => 0,
                ];
            }

            $counters[$id]['all']++;
            if ($isPositive) {
                $counters[$id]['positive']++;
            }

            $review = new Review();
            $review->setMovie($movie)
                ->setIsPositive($isPositive)
                ->setComment($comment);

            $manager->persist($review);
        }

        foreach ($counters as $data) {
            /** @var Movie $movie */
            $movie = $data['movie'];
            $movie
                ->setAllReviewsCount($data['all'])
                ->setPositiveReviewsCount($data['positive']);

            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [MovieFixture::class];
    }
}
