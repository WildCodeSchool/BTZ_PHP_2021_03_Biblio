<?php

namespace App\Repository;

use App\Entity\PublicationType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PublicationType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicationType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicationType[]    findAll()
 * @method PublicationType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublicationType::class);
    }

    // /**
    //  * @return PublicationType[] Returns an array of PublicationType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PublicationType
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
