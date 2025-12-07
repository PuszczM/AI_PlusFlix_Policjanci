<?php

namespace App\Controller;

use App\Filter\MovieFilter;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        #[MapQueryParameter] ?string $prompt,
        #[MapQueryParameter] ?string $categories,
        #[MapQueryParameter] ?string $services,
        #[MapQueryParameter] ?bool $isRated18,
        #[MapQueryParameter] ?int $year,
        MovieRepository $movieRepository
    ): Response
    {
        $filter = new MovieFilter(
            $prompt,
            $categories ? array_map('trim', explode(',', $categories)) : [],
            $services ? array_map('trim', explode(',', $services)) : [],
            $isRated18,
            $year
        );

        $movies = $movieRepository->findMoviesByFilter($filter);

        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'prompt' => $filter->prompt,
            'categories' => $filter->categories,
            'services' => $filter->services,
            'isRated18' => $filter->isRated18,
            'year' => $filter->year,
        ]);
    }
}
