<?php

namespace App\Controller\Admin;

use App\DTO\MovieDTO;
use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\CategoryRepository;
use App\Repository\MovieRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AddMovieController extends AbstractController
{
    #[Route('/admin/movies/add', name: 'admin_add_movie', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(
        CategoryRepository $categoryRepository,
        ServiceRepository  $serviceRepository): Response
    {
        $form = $this->createForm(MovieType::class, new MovieDTO(), [
            'categories' => $categoryRepository->findAll(),
            'services' => $serviceRepository->findAll(),
        ]);

        return $this->render('admin/add-movie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/movies/add/submit', name: 'admin_add_movie_submit', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function submit(
        Request $request,
        MovieRepository $movieRepository,
        CategoryRepository $categoryRepository,
        ServiceRepository $serviceRepository
    ): Response {
        $dto = new MovieDTO();
        $form = $this->createForm(MovieType::class, $dto, [
            'categories' => $categoryRepository->findAll(),
            'services' => $serviceRepository->findAll(),
        ]);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('admin/add-movie.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $movie = new Movie();
        $movie
            ->setTitle($dto->title)
            ->setDescription($dto->description)
            ->setReleaseYear($dto->releaseYear)
            ->setCountry($dto->country)
            ->setIsSeries($dto->isSeries)
            ->setPosterPath($dto->posterPath)
            ->setIsAdult($dto->isAdult);

        foreach ($dto->categories as $category) {
            $movie->addCategory($category);
        }

        foreach ($dto->services as $service) {
            $movie->addService($service);
        }

        try {
            $movieRepository->add($movie);
            $this->addFlash('success', 'Movie added successfully!');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Failed to add movie: ' . $e->getMessage());
        }

        return $this->redirectToRoute('admin_add_movie');
    }
}
