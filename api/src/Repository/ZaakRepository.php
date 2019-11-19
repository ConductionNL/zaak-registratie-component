<?php

namespace App\Repository;

use App\Entity\Zaak;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Zaak|null find($id, $lockMode = null, $lockVersion = null)
 * @method Zaak|null findOneBy(array $criteria, array $orderBy = null)
 * @method Zaak[]    findAll()
 * @method Zaak[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZaakRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zaak::class);
    }

    // /**
    //  * @return Zaak[] Returns an array of Zaak objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('z.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Zaak
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
