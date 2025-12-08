<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/{id}', name: 'movie_show')]
    public function show(Movie $movie, ReviewRepository $reviewRepository): Response
    {
        $reviews = $reviewRepository->findBy(['movie' => $movie]);

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'reviews' => $reviews
        ]);
    }
}
