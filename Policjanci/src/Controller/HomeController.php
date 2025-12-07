<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // <--- WAŻNE: Dodaj to!
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(#[MapQueryParameter] ?string $prompt,
                          MovieRepository $movieRepository): Response
    {
        $movies = [];

        $movies = $movieRepository->findMovies($prompt);

        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'prompt' => $prompt,
        ]);
    }
}
