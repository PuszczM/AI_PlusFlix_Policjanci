<?php

namespace App\Controller\Admin;

use App\DTO\MovieDTO;
use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\CategoryRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddMovieController extends AbstractController
{
    #[Route('/admin/movies/add', name: 'admin_add_movie', methods: ['GET'])]
    public function index(): Response
    {
        $form = $this->createForm(MovieType::class, new MovieDTO());

        return $this->render('admin/add-movie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/movies/add/submit', name: 'admin_add_movie_submit', methods: ['POST'])]
    public function submit(
        Request $request,
        EntityManagerInterface $em,
        CategoryRepository $categoryRepo,
        ServiceRepository $serviceRepo
    ): Response {
        $dto = new MovieDTO();
        $form = $this->createForm(MovieType::class, $dto);
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

        // Map ids to entities
        foreach ($dto->categories as $catId) {
            $category = $categoryRepo->find($catId);
            if ($category) {
                $movie->addCategory($category);
            }
        }

        foreach ($dto->services as $srvId) {
            $service = $serviceRepo->find($srvId);
            if ($service) {
                $movie->addService($service);
            }
        }

        $em->persist($movie);
        $em->flush();

        $this->addFlash('success', 'Movie added successfully!');

        return $this->redirectToRoute('admin_add_movie');
    }
}
