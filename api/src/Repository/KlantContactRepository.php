<?php

namespace App\Repository;

use App\Entity\KlantContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method KlantContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method KlantContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method KlantContact[]    findAll()
 * @method KlantContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KlantContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KlantContact::class);
    }

    // /**
    //  * @return KlantContact[] Returns an array of KlantContact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KlantContact
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
