<?php

namespace App\Repository;

use App\Entity\SessionTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SessionTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessionTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessionTest[]    findAll()
 * @method SessionTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SessionTest::class);
    }

    // /**
    //  * @return SessionTest[] Returns an array of SessionTest objects
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
    public function findOneBySomeField($value): ?SessionTest
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
