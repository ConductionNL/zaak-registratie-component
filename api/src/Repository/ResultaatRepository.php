<?php

namespace App\Repository;

use App\Entity\Resultaat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Resultaat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resultaat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resultaat[]    findAll()
 * @method Resultaat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultaatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resultaat::class);
    }

    // /**
    //  * @return Resultaat[] Returns an array of Resultaat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Resultaat
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
