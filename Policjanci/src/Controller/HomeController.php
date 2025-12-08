<?php

namespace App\Controller;

use App\Filter\MovieFilter;
use App\Filter\MovieTypeFilter;
use App\Repository\MovieRepository;
use App\Repository\CategoryRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        #[MapQueryParameter] ?string $prompt = null,
        #[MapQueryParameter] ?string $categories,
        #[MapQueryParameter] ?string $services,
        #[MapQueryParameter] ?bool $isRated18 = null,
        #[MapQueryParameter] ?int $yearAfter = null,
        #[MapQueryParameter] ?int $yearBefore = null,
        #[MapQueryParameter] ?string $country = null,
        #[MapQueryParameter] ?int $minScore = null,
        #[MapQueryParameter] ?int $maxScore = null,
        #[MapQueryParameter] ?string $type = null,
        MovieRepository $movieRepository,
        ServiceRepository $serviceRepository
    ): Response
    {
        $availableServices = $serviceRepository->findAllOrdered();
        // 🔥 tłumaczenie stringa "film" / "series" -> enum
        $movieType = $type ? MovieTypeFilter::from($type) : null;

        $filter = new MovieFilter(
            $prompt,
            $categories ? array_map('trim', explode(',', $categories)) : [],
            $services ? array_map('trim', explode(',', $services)) : [],
            $isRated18,
            $yearAfter,
            $yearBefore,
            $country,
            $minScore,
            $maxScore,
            $movieType
        );

        $movies = $movieRepository->findMoviesByFilter($filter);

        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'prompt' => $prompt,
            'categories' => $filter->categories,
            'services' => $filter->services,
            'isRated18' => $filter->isRated18,
            'yearBefore' => $filter->yearBefore,
            'yearAfter' => $filter->yearAfter,
            'country' => $filter->country,
            'minScore' => $filter->minScore,
            'maxScore' => $filter->maxScore,
            'type' => $type,
            'availableServices' => $availableServices
        ]);
    }

    #[Route('/search', name: 'app_search')]
    public function search(
        #[MapQueryParameter] ?string $prompt = null,
        #[MapQueryParameter] ?string $categories,
        #[MapQueryParameter] ?string $services,
        #[MapQueryParameter] ?bool $isRated18 = null,
        #[MapQueryParameter] ?int $yearAfter = null,
        #[MapQueryParameter] ?int $yearBefore = null,
        #[MapQueryParameter] ?string $country = null,
        #[MapQueryParameter] ?int $minScore = null,
        #[MapQueryParameter] ?int $maxScore = null,
        #[MapQueryParameter] ?MovieTypeFilter $type = null,
        MovieRepository $movieRepository,
        CategoryRepository $categoryRepository,
        ServiceRepository $serviceRepository
    ): Response
    {
        $availableServices = $serviceRepository->findAllOrdered();
        $filter = new MovieFilter(
            $prompt,
            $categories ? array_map('trim', explode(',', $categories)) : [],
            $services ? array_map('trim', explode(',', $services)) : [],
            $isRated18,
            $yearAfter,
            $yearBefore,
            $country,
            $minScore,
            $maxScore,
            $type
        );

        return $this->render('movie/search.html.twig', [
            'movies' => $movieRepository->findMoviesByFilter($filter),
            'prompt' => $prompt,
            'categories' => $categoryRepository->findAll(),
            'selectedCategories' => $filter->categories,

            'services' => $filter->services,
            'isRated18' => $filter->isRated18,
            'yearAfter' => $filter->yearAfter,
            'yearBefore' => $filter->yearBefore,
            'country' => $filter->country,
            'minScore' => $filter->minScore,
            'maxScore' => $filter->maxScore,

            // 🔥 always string for Twig
            'type' => $filter->movieType?->value,

            'availableServices' => $availableServices
        ]);
    }
}
