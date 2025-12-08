<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Filter\MovieFilter;
use App\Filter\MovieTypeFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function findMoviesByFilter(MovieFilter $filter): array
    {
        $qb = $this->createQueryBuilder('m');

        $this->applyPromptFilter($qb, $filter->prompt);
        $this->applyCategoryFilter($qb, $filter->categories);
        $this->applyServiceFilter($qb, $filter->services);
        $this->applyAdultFilter($qb, $filter->isRated18);
        $this->applyYearFilter($qb, $filter->yearAfter, $filter->yearBefore);
        $this->applyCountryFilter($qb, $filter->country);
        $this->applyScoreFilter($qb, $filter->minScore, $filter->maxScore);
        $this->applyTypeFilter($qb, $filter->movieType);

        return $qb->getQuery()->getResult();
    }

    private function applyPromptFilter($qb, ?string $prompt): void
    {
        if ($prompt) {
            $qb->andWhere('m.title LIKE :prompt')
                ->setParameter('prompt', '%' . $prompt . '%');
        }
    }

    private function applyCategoryFilter($qb, array $categories): void
    {
        if (!empty($categories)) {
            $qb->innerJoin('m.categories', 'c')
                ->andWhere($qb->expr()->in('c.name', ':categories'))
                ->setParameter('categories', $categories);
        }
    }

    private function applyServiceFilter($qb, array $services): void
    {
        if (!empty($services)) {
            $qb->innerJoin('m.services', 's')
                ->andWhere($qb->expr()->in('s.shortName', ':services'))
                ->setParameter('services', $services);
        }
    }

    private function applyAdultFilter($qb, ?bool $isRated18): void
    {
        if ($isRated18 !== null) {
            $qb->andWhere('m.isAdult = :isRated18')
                ->setParameter('isRated18', $isRated18);
        }
    }

    private function applyYearFilter($qb, ?int $yearAfter, ?int $yearBefore): void
    {
        if ($yearAfter !== null) {
            $qb->andWhere('m.releaseYear >= :yearAfter')
                ->setParameter('yearAfter', $yearAfter);
        }
        if ($yearBefore !== null) {
            $qb->andWhere('m.releaseYear <= :yearBefore')
                ->setParameter('yearBefore', $yearBefore);
        }
    }

    private function applyCountryFilter($qb, ?string $country): void
    {
        if ($country !== null) {
            $qb->andWhere('m.country = :country')
                ->setParameter('country', $country);
        }
    }

    private function applyScoreFilter($qb, ?int $minScore, ?int $maxScore): void
    {
        $scoreExpr = '(CASE
            WHEN m.allReviewsCount IS NULL OR m.allReviewsCount = 0
                THEN 0
            WHEN m.positiveReviewsCount IS NULL
                THEN 0
            ELSE (m.positiveReviewsCount * 100.0 / m.allReviewsCount)
        END)';

        if ($minScore !== null) {
            $qb->andWhere("$scoreExpr >= :minScore")
                ->setParameter('minScore', $minScore);
        }
        if ($maxScore !== null) {
            $qb->andWhere("$scoreExpr <= :maxScore")
                ->setParameter('maxScore', $maxScore);
        }
    }

    private function applyTypeFilter($qb, ?MovieTypeFilter $type): void
    {
        if ($type !== null) {
            switch ($type) {
                case MovieTypeFilter::FILM:
                    $qb->andWhere('m.isSeries = :isSeries')
                        ->setParameter('isSeries', false);
                    break;
                case MovieTypeFilter::SERIES:
                    $qb->andWhere('m.isSeries = :isSeries')
                        ->setParameter('isSeries', true);
                    break;
            }
        }
    }
}
