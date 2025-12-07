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
                          #[MapQueryParameter] ?string $services,
                          #[MapQueryParameter] ?bool $isRated18,
                          #[MapQueryParameter] ?int $year,
                          MovieRepository $movieRepository): Response
    {
        $categoryNames = $categories ? explode(',', $categories) : [];
        $serviceNames = $services ? explode(',', $services) : [];

        $movies = $movieRepository->findMovies($prompt, $categoryNames, $serviceNames, $isRated18, $year);

        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'prompt' => $prompt,
            'categories' => $categoryNames,
            'services' => $serviceNames,
            'isRated18' => $isRated18,
            'year' => $year
        ]);
    }
}
