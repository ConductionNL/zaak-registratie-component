<?php

namespace App\Repository;

use App\Entity\ZaakInformatieObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ZaakInformatieObject|null find($id, $lockMode = null, $lockVersion = null)
 * @method ZaakInformatieObject|null findOneBy(array $criteria, array $orderBy = null)
 * @method ZaakInformatieObject[]    findAll()
 * @method ZaakInformatieObject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZaakInformatieObjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZaakInformatieObject::class);
    }

    // /**
    //  * @return ZaakInformatieObject[] Returns an array of ZaakInformatieObject objects
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
    public function findOneBySomeField($value): ?ZaakInformatieObject
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
