<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Review;
use App\Entity\Service;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // ==========================================
        // 1. TWORZENIE UŻYTKOWNIKÓW (USERS)
        // ==========================================
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'admin123');
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        // ==========================================
        // 2. TWORZENIE KATEGORII
        // ==========================================
        $categories = [];
        $categoryNames = [
            'Horror', 'Drama', 'Crime', 'Thriller',
            'Comedy', 'Sci-Fi', 'Action', 'Series'
        ];

        foreach ($categoryNames as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $categories[$name] = $category;
        }

        // ==========================================
        // 3. TWORZENIE SERWISÓW
        // ==========================================
        $services = [];
        $servicesData = [
            ['short' => 'apple', 'full' => 'Apple TV+', 'logo' => '/img/service/apple.png'],
            ['short' => 'disney', 'full' => 'Disney Plus', 'logo' => '/img/service/disney.png'],
            ['short' => 'hbo', 'full' => 'HBO Max', 'logo' => '/img/service/hbo.png'],
            ['short' => 'netflix', 'full' => 'Netflix', 'logo' => '/img/service/netflix.png'],
            ['short' => 'prime', 'full' => 'Prime Video', 'logo' => '/img/service/prime.png'],
            ['short' => 'skyshowtime', 'full' => 'SkyShowtime', 'logo' => '/img/service/skyshowtime.png'],
        ];

        foreach ($servicesData as $data) {
            $service = new Service();
            $service->setShortName($data['short']);
            $service->setFullName($data['full']);
            $service->setLogoPath($data['logo']);

            $manager->persist($service);
            $services[$data['short']] = $service;
        }

        // ==========================================
        // 4. TWORZENIE FILMÓW
        // ==========================================

        $createMovie = function($title, $desc, $year, $poster, $isAdult, $cats, $servs, $reviewsData) use ($manager, $categories, $services) {
            $movie = new Movie();
            $movie->setTitle($title);
            $movie->setDescription($desc);
            $movie->setReleaseYear($year);
            $movie->setIsAdult($isAdult);

            // --- ZMIANA TUTAJ: Używamy setPosterPath zamiast setImage ---
            $movie->setPosterPath($poster);
            // ------------------------------------------------------------

            // Dodajemy Kategorie
            foreach ($cats as $catName) {
                if (isset($categories[$catName])) {
                    $movie->addCategory($categories[$catName]);
                }
            }

            // Dodajemy Serwisy (Zadziała tylko jak masz relację w Movie.php!)
            foreach ($servs as $servShort) {
                if (isset($services[$servShort])) {
                    // Jeśli Twoja encja Movie nie ma metody addService, zakomentuj te 3 linijki poniżej:
                    if (method_exists($movie, 'addService')) {
                        $movie->addService($services[$servShort]);
                    }
                }
            }

            $manager->persist($movie);

            // Dodajemy Opinie
            foreach ($reviewsData as $revData) {
                $review = new Review();
                $review->setMovie($movie);
                $review->setIsPositive($revData['positive']);
                $review->setComment($revData['comment']);
                $manager->persist($review);
            }
        };

        // --- DANE FILMÓW ---

        $createMovie('The Human Centipede', 'A mad scientist surgically joins people together.', 2009, '/img/posters/human_centipide.png', true, ['Horror', 'Thriller'], ['hbo'], [['positive' => false, 'comment' => 'I wish I could uninstall this movie from my brain'], ['positive' => false, 'comment' => 'Woke']]);
        $createMovie('Breaking Bad', 'A chemistry teacher turns to making drugs after cancer diagnosis.', 2008, '/img/posters/breaking_bad.png', false, ['Drama', 'Crime', 'Series'], ['netflix'], [['positive' => true, 'comment' => 'Walter White cooked Heisenburger.'], ['positive' => true, 'comment' => 'Vravo Bince!']]);
        $createMovie('Better Call Saul', 'The story of Jimmy McGill becoming Saul Goodman.', 2015, '/img/posters/better_call_saul.png', false, ['Drama', 'Crime', 'Series'], ['netflix', 'prime'], [['positive' => true, 'comment' => 'I would let Saul Goodman represent me even if I was guilty.'], ['positive' => true, 'comment' => 'Best CRIMINAL lawyer ever']]);
        $createMovie('Inception', 'A skilled thief enters dreams to steal secrets.', 2010, '/img/posters/inception.png', false, ['Sci-Fi', 'Action', 'Thriller'], ['apple', 'prime'], [['positive' => true, 'comment' => 'Was dreaming that I understood the plot.']]);
        $createMovie('The Dark Knight', 'Batman faces the Joker in Gotham.', 2008, '/img/posters/dark_knight.png', false, ['Action', 'Crime', 'Drama'], ['hbo', 'apple'], [['positive' => true, 'comment' => 'We live in a society% world record attempt.'], ['positive' => false, 'comment' => 'I tried to become the Joker.']]);
        $createMovie('Interstellar', 'A team travels through a wormhole to save humanity.', 2014, '/img/posters/interstellar.png', false, ['Sci-Fi', 'Drama'], ['prime', 'skyshowtime'], [['positive' => true, 'comment' => 'Cried at the bookshelf scene'], ['positive' => false, 'comment' => 'No amogus :(']]);
        $createMovie('The Matrix', 'A hacker discovers reality is a simulation.', 1999, '/img/posters/matrix.png', false, ['Sci-Fi', 'Action'], ['hbo', 'prime'], [['positive' => true, 'comment' => 'Slay, Neo!'], ['positive' => true, 'comment' => 'Red pills BEFORE the internet ruined the metaphor']]);
        $createMovie('Pulp Fiction', 'Intersecting stories of crime in Los Angeles.', 1994, '/img/posters/pulp_fiction.png', true, ['Crime', 'Drama'], ['prime', 'hbo'], [['positive' => false, 'comment' => 'I did not watch this']]);
        $createMovie('The Shawshank Redemption', 'A man wrongly imprisoned seeks hope and freedom.', 1994, '/img/posters/shawshank_redemption.png', false, ['Drama'], ['netflix', 'prime'], []);
        $createMovie('Stranger Things', 'Kids uncover mysterious events in their town.', 2016, '/img/posters/stranger_things.png', false, ['Series', 'Sci-Fi', 'Thriller'], ['netflix'], [['positive' => true, 'comment' => 'Peak parenting.'], ['positive' => false, 'comment' => 'Ohio irl is better']]);

        $manager->flush();
    }
}
