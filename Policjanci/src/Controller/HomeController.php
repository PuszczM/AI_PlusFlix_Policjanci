<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(#[MapQueryParameter] ?string $prompt,
                          #[MapQueryParameter] ?string $categories,
                          MovieRepository $movieRepository): Response
    {
        $categoryNames = $categories ? explode(',', $categories) : [];

        $movies = $movieRepository->findMovies($prompt, $categoryNames);

        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'prompt' => $prompt,
            'categories' => $categoryNames
        ]);
    }
}
