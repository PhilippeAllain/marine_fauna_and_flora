<?php

namespace App\Repository;

use App\Entity\Faunaspecie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;


/**
 * @extends ServiceEntityRepository<Faunaspecie>
 */
class FaunaspecieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Faunaspecie::class);
    }

    public function paginateFaunaspecies(int $page, int $limit): PaginationInterface
    {

        return $this->paginator->paginate(
            $this->createQueryBuilder('f'),
            $page,
            $limit,
            [
                'distinct' => false, // Disable distinct to avoid issues with pagination
                'sortFieldWhitelist' => ['f.id', 'f.name'], // Whitelist fields for sorting
            ]
        );
       /*
        return new Paginator($this
            ->createQueryBuilder('f')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery(Paginator::HINT_ENABLE_DISTINCT, false)
        );
         */
    }
       

    //    /**
    //     * @return Faunaspecie[] Returns an array of Faunaspecie objects
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

    //    public function findOneBySomeField($value): ?Faunaspecie
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
