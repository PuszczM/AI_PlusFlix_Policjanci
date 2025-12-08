<?php

namespace App\Controller;

use App\DTO\PostReviewDTO;
use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/{id}', name: 'movie_show')]
    public function show(Movie $movie, ReviewRepository $reviewRepository): Response
    {
        $reviews = $reviewRepository->findCommentsByMovie($movie);

        $reviewData = new PostReviewDTO();

        $form = $this->createForm(ReviewType::class, $reviewData, [
            'action' => $this->generateUrl('add_review', ['id' => $movie->getId()]),
            'method' => 'POST',
        ]);

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'reviews' => $reviews,
            'reviewForm' => $form->createView(),
        ]);
    }

    #[Route('/movie/{id}/add-review', name: 'add_review', methods: ['POST'])]
    public function addReview(
        Movie $movie,
        ReviewRepository $reviewRepository,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $reviewDto = new PostReviewDTO();

        $form = $this->createForm(ReviewType::class, $reviewDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review = new Review();
            $review->setUsername($reviewDto->author);
            $review->setComment($reviewDto->comment);
            $review->setIsPositive($reviewDto->positive);
            $review->setCreatedAt(new \DateTimeImmutable());

            $reviewRepository->addReview($movie, $review);
        }

        return $this->redirectToRoute('movie_show', ['id' => $movie->getId()]);
    }

}
