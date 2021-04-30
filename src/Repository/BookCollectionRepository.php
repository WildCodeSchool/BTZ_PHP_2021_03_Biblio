<?php

namespace App\Repository;

use App\Entity\BookCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookCollection|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookCollection[]    findAll()
 * @method BookCollection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookCollection::class);
    }

    // /**
    //  * @return BookCollection[] Returns an array of BookCollection objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookCollection
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
