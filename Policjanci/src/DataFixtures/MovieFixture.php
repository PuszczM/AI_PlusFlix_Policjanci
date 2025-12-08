<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movies = [
            // title, description, year, poster, isAdult, country, isSeries
            ['The Human Centipede', 'A mad scientist surgically joins people together.', 2009, "/img/posters/human_centipede.png", true, 'Netherlands', false],
            ['Breaking Bad', 'A chemistry teacher turns to making drugs after cancer diagnosis.', 2008, "/img/posters/breaking_bad.png", false, 'USA', true],
            ['Better Call Saul', 'The story of Jimmy McGill becoming Saul Goodman.', 2015, "/img/posters/better_call_saul.png", false, 'USA', true],
            ['Inception', 'A skilled thief enters dreams to steal secrets.', 2010, "/img/posters/inception.png", false, 'USA', false],
            ['The Dark Knight', 'Batman faces the Joker in Gotham.', 2008, "/img/posters/dark_knight.png", false, 'USA', false],
            ['Interstellar', 'A team travels through a wormhole to save humanity.', 2014, "/img/posters/interstellar.png", false, 'USA', false],
            ['The Matrix', 'A hacker discovers reality is a simulation.', 1999, "/img/posters/matrix.png", false, 'USA', false],
            ['Pulp Fiction', 'Intersecting stories of crime in Los Angeles.', 1994, "/img/posters/pulp_fiction.png", true, 'USA', false],
            ['The Shawshank Redemption', 'A man wrongly imprisoned seeks hope and freedom.', 1994, "/img/posters/shawshank_redemption.png", false, 'USA', false],
            ['Stranger Things', 'Kids uncover mysterious events in their town.', 2016, "/img/posters/stranger_things.png", false, 'USA', true],
        ];

        foreach ($movies as [$title, $description, $year, $poster, $adult, $country, $isSeries]) {
            $movie = new Movie();
            $movie->setTitle($title)
                ->setDescription($description)
                ->setReleaseYear($year)
                ->setPosterPath($poster)
                ->setIsAdult($adult)
                ->setCountry($country)
                ->setIsSeries($isSeries);

            $manager->persist($movie);
            $this->addReference('movie_'.$title, $movie);
        }

        $manager->flush();
    }
}
