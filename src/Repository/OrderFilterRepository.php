<?php

namespace App\Repository;

use App\Entity\OrderFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderFilter|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderFilter|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderFilter[]    findAll()
 * @method OrderFilter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderFilterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderFilter::class);
    }

    public function findByUser($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.user = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return OrderFilter[] Returns an array of OrderFilter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderFilter
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
