<?php

namespace App\Repository;

use App\Entity\Review;
use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function findCommentsByMovie(Movie $movie): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.movie = :movie')
            ->setParameter('movie', $movie)
            ->andWhere('r.comment IS NOT NULL')
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function addReview(Movie $movie, Review $review): void
    {
        $em = $this->getEntityManager();

        $em->getConnection()->beginTransaction();

        try {
            $review->setMovie($movie);

            $movie->setAllReviewsCount($movie->getAllReviewsCount() + 1);

            if ($review->isPositive()) {
                $movie->setPositiveReviewsCount($movie->getPositiveReviewsCount() + 1);
            }

            $em->persist($review);
            $em->persist($movie);

            $em->flush();

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollBack();
            throw $e;
        }
    }
}
