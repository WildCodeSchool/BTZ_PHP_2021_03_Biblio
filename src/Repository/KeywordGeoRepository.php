<?php

namespace App\Repository;

use App\Entity\KeywordGeo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KeywordGeo|null find($id, $lockMode = null, $lockVersion = null)
 * @method KeywordGeo|null findOneBy(array $criteria, array $orderBy = null)
 * @method KeywordGeo[]    findAll()
 * @method KeywordGeo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeywordGeoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KeywordGeo::class);
    }

    // /**
    //  * @return KeywordGeo[] Returns an array of KeywordGeo objects
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
    public function findOneBySomeField($value): ?KeywordGeo
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
