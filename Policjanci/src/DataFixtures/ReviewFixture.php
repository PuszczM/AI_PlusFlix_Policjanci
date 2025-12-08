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
            ['Breaking Bad', true, 'Walter White cooked Heisenburger.', null],
            ['Breaking Bad', true, 'Vravo Bince!', 'skong_enjoyer'],
            ['Breaking Bad', true, null, null],
            ['Breaking Bad', true, null, null],
            ['Breaking Bad', true, null, null],
            ['Breaking Bad', true, null, null],
            ['Breaking Bad', false, null, null],

            ['Better Call Saul', true, 'I would let Saul Goodman represent me even if I was guilty. Especially if I was guilty.', null],
            ['Better Call Saul', true, 'Best CRIMINAL lawyer ever', 'pinkguy'],
            ['Better Call Saul', true, null, null],
            ['Better Call Saul', false, null, null],

            ['The Matrix', true, 'The Matrix is the most accidentally-trans-then-intentionally-trans masterpiece ever. Slay, Neo!', 'sophie21'],
            ['The Matrix', true, 'This movie invented red pills BEFORE the internet ruined the metaphor', 'nic3guy'],
            ['The Matrix', true, null, null],
            ['The Matrix', true, null, null],
            ['The Matrix', false, null, null],

            ['The Dark Knight', true, 'We live in a society% world record attempt.', 'skong_enjoyer'],
            ['The Dark Knight', false, 'I tried to become the Joker after watching this. Did not work. Landlord still wants rent...', 'joeduh'],
            ['The Dark Knight', true, null, null],
            ['The Dark Knight', true, null, null],
            ['The Dark Knight', true, null, null],
            ['The Dark Knight', true, null, null],
            ['The Dark Knight', false, null, null],
            ['The Dark Knight', false, null, null],
            ['The Dark Knight', false, null, null],
            ['The Dark Knight', false, null, null],
            ['The Dark Knight', false, null, null],

            ['Inception', true, 'Was dreaming that I understood the plot. Woke up confused again 10/10', null],

            ['Interstellar', true, 'Cried at the bookshelf scene', 'roxie2008'],
            ['Interstellar', false, 'No amogus :(', 'skong_enjoyer'],
            ['Interstellar', true, null, null],
            ['Interstellar', true, null, null],
            ['Interstellar', false, null, null],

            ['Pulp Fiction', false, 'I did not watch this', 'skong_enjoyer'],
            ['Pulp Fiction', true, null, null],
            ['Pulp Fiction', true, null, null],
            ['Pulp Fiction', true, null, null],
            ['Pulp Fiction', true, null, null],
            ['Pulp Fiction', true, null, null],
            ['Pulp Fiction', true, null, null],

            ['Stranger Things', true, 'Kids fighting monsters while adults argue. Peak parenting.', 'brah69'],
            ['Stranger Things', false, 'Ohio irl is better', 'skong_enjoyer'],
            ['Stranger Things', true, null, null],
            ['Stranger Things', true, null, null],
            ['Stranger Things', false, null, null],
            ['Stranger Things', false, null, null],
            ['Stranger Things', false, null, null],

            ['The Human Centipede', false, 'I wish I could uninstall this movie from my brain', 'soyboy'],
            ['The Human Centipede', false, 'Woke', 'trump2028'],
            ['The Human Centipede', false, null, null],
            ['The Human Centipede', false, null, null],
            ['The Human Centipede', false, null, null],
            ['The Human Centipede', false, null, null],
            ['The Human Centipede', false, null, null],
        ];

        $counters = [];

        foreach ($reviews as [$movieName, $isPositive, $comment, $username]) {
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
                ->setComment($comment)
                ->setUsername($username);

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
