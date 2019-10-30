<?php

namespace App\Repository;

use App\Entity\TestAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TestAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestAnswer[]    findAll()
 * @method TestAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestAnswer::class);
    }

    // /**
    //  * @return TestAnswer[] Returns an array of TestAnswer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TestAnswer
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
