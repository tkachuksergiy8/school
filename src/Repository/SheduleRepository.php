<?php

namespace App\Repository;

use App\Entity\Shedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Shedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shedule[]    findAll()
 * @method Shedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shedule::class);
    }

    // /**
    //  * @return Shedule[] Returns an array of Shedule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Shedule
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
