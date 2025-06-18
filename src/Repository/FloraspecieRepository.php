<?php

namespace App\Repository;

use App\Entity\Floraspecie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @extends ServiceEntityRepository<Floraspecie>
 */
class FloraspecieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Floraspecie::class);
    }

        public function paginateFloraSpecies(int $page , int $limit): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('f'),
            $page,
            $limit,
            [
                'distnct' => false,
                'sortFieldAllowList' => ['f.id', 'f.name'],
            ]

        );
    }

    //    /**
    //     * @return Floraspecie[] Returns an array of Floraspecie objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Floraspecie
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
