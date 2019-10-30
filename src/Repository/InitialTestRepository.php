<?php

namespace App\Repository;

use App\Entity\InitialTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InitialTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method InitialTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method InitialTest[]    findAll()
 * @method InitialTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InitialTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InitialTest::class);
    }

    // /**
    //  * @return InitialTest[] Returns an array of InitialTest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InitialTest
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
