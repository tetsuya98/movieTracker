<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
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

    // /**
    //  * @return Movie[] Returns an array of Movie objects
    //  */

    public function findByUser($value, $order, $asc)
    {
        if ($asc == "ASC") {
            if ($order == "alpha") {
                return $this->createQueryBuilder('m')
                    ->andWhere('m.user = :val')
                    ->setParameter('val', $value)
                    ->orderBy('m.title', 'ASC')
                    ->getQuery()
                    ->getResult()
                    ;
            }
            if ($order == "added") {
                return $this->createQueryBuilder('m')
                    ->andWhere('m.user = :val')
                    ->setParameter('val', $value)
                    ->orderBy('m.id', 'ASC')
                    ->getQuery()
                    ->getResult()
                    ;
            }
            if ($order == "release") {
                return $this->createQueryBuilder('m')
                    ->andWhere('m.user = :val')
                    ->setParameter('val', $value)
                    ->orderBy('m.release_date', 'ASC')
                    ->getQuery()
                    ->getResult()
                    ;
            }
            if ($order == "vue") {
                return $this->createQueryBuilder('m')
                    ->andWhere('m.user = :val')
                    ->setParameter('val', $value)
                    ->orderBy('m.vue_date', 'ASC')
                    ->getQuery()
                    ->getResult();
            }
        }else{
            if ($order == "alpha") {
                return $this->createQueryBuilder('m')
                    ->andWhere('m.user = :val')
                    ->setParameter('val', $value)
                    ->orderBy('m.title', 'DESC')
                    ->getQuery()
                    ->getResult()
                    ;
            }
            if ($order == "added") {
                return $this->createQueryBuilder('m')
                    ->andWhere('m.user = :val')
                    ->setParameter('val', $value)
                    ->orderBy('m.create_date', 'DESC')
                    ->getQuery()
                    ->getResult()
                    ;
            }
            if ($order == "release") {
                return $this->createQueryBuilder('m')
                    ->andWhere('m.user = :val')
                    ->setParameter('val', $value)
                    ->orderBy('m.release_date', 'DESC')
                    ->getQuery()
                    ->getResult()
                    ;
            }
            if ($order == "vue") {
                return $this->createQueryBuilder('m')
                    ->andWhere('m.user = :val')
                    ->setParameter('val', $value)
                    ->orderBy('m.vue_date', 'DESC')
                    ->getQuery()
                    ->getResult()
                    ;
            }
        }
    }

    public function findByVue($value, $filter, $order, $asc)
    {
        if ($asc == "ASC") {
            if ($order == "alpha") {
                return $this->createQueryBuilder('m')
                    ->andWhere('m.user = :val')
                    ->setParameter('val', $value)
                    ->andWhere('m.vue = :filter')
                    ->setParameter('filter', $filter)
                    ->orderBy('m.title', 'ASC')
                    ->getQuery()
                    ->getResult()
                    ;
            }
            if ($order == "added") {
                return $this->createQueryBuilder('m')
                    ->andWhere('m.user = :val')
                    ->setParameter('val', $value)
                    ->andWhere('m.vue = :filter')
                    ->setParameter('filter', $filter)
                    ->orderBy('m.id', 'ASC')
                    ->getQuery()
                    ->getResult()
                    ;
            }
            if ($order == "release") {
                return $this->createQueryBuilder('m')
                    ->andWhere('m.user = :val')
                    ->setParameter('val', $value)
                    ->andWhere('m.vue = :filter')
                    ->setParameter('filter', $filter)
                    ->orderBy('m.release_date', 'ASC')
                    ->getQuery()
                    ->getResult()
                    ;
            }
            if ($order == "vue") {
                return $this->createQueryBuilder('m')
                    ->andWhere('m.user = :val')
                    ->setParameter('val', $value)
                    ->andWhere('m.vue = :filter')
                    ->setParameter('filter', $filter)
                    ->orderBy('m.vue_date', 'ASC')
                    ->getQuery()
                    ->getResult();
            }
        }else{
            if ($order == "alpha") {
                    return $this->createQueryBuilder('m')
                        ->andWhere('m.user = :val')
                        ->setParameter('val', $value)
                        ->andWhere('m.vue = :filter')
                        ->setParameter('filter', $filter)
                        ->orderBy('m.title', 'DESC')
                        ->getQuery()
                        ->getResult()
                        ;
                }
            if ($order == "added") {
                    return $this->createQueryBuilder('m')
                        ->andWhere('m.user = :val')
                        ->setParameter('val', $value)
                        ->andWhere('m.vue = :filter')
                        ->setParameter('filter', $filter)
                        ->orderBy('m.create_date', 'DESC')
                        ->getQuery()
                        ->getResult()
                        ;
                }
            if ($order == "release") {
                    return $this->createQueryBuilder('m')
                        ->andWhere('m.user = :val')
                        ->setParameter('val', $value)
                        ->andWhere('m.vue = :filter')
                        ->setParameter('filter', $filter)
                        ->orderBy('m.release_date', 'DESC')
                        ->getQuery()
                        ->getResult()
                        ;
                }
            if ($order == "vue") {
                    return $this->createQueryBuilder('m')
                        ->andWhere('m.user = :val')
                        ->setParameter('val', $value)
                        ->andWhere('m.vue = :filter')
                        ->setParameter('filter', $filter)
                        ->orderBy('m.vue_date', 'DESC')
                        ->getQuery()
                        ->getResult()
                        ;
                }
        }
    }

    /*
    public function findOneBySomeField($value): ?Movie
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
