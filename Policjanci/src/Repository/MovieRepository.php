<?php

namespace App\Repository;

use App\Entity\Movie;
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

    public function findMovies(?string $prompt, ?array $categoryNames, ?array $serviceNames): array
    {
        $queryBuilder = $this->createQueryBuilder('m');

        if ($prompt) {
            $queryBuilder = $queryBuilder
                ->andWhere('m.title LIKE :val')
                ->setParameter('val', '%' . $prompt . '%');
        }

        if ($categoryNames && count($categoryNames) > 0) {
            $queryBuilder->innerJoin('m.categories', 'c')
                ->andWhere('c.name IN (:cNames)')
                ->setParameter('cNames', $categoryNames);
        }

        if ($serviceNames && count($serviceNames) > 0) {
            $queryBuilder->innerJoin('m.services', 's')
                ->andWhere('s.shortName IN (:sNames)')
                ->setParameter('sNames', $serviceNames);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
