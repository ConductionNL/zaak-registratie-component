<?php

namespace App\Repository;

use App\Entity\ZaakObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ZaakObject|null find($id, $lockMode = null, $lockVersion = null)
 * @method ZaakObject|null findOneBy(array $criteria, array $orderBy = null)
 * @method ZaakObject[]    findAll()
 * @method ZaakObject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZaakObjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZaakObject::class);
    }

    // /**
    //  * @return ZaakObject[] Returns an array of ZaakObject objects
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
    public function findOneBySomeField($value): ?ZaakObject
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
