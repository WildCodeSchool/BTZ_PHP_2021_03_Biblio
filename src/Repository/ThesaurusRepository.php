<?php

namespace App\Repository;

use App\Entity\Thesaurus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Thesaurus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Thesaurus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Thesaurus[]    findAll()
 * @method Thesaurus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThesaurusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Thesaurus::class);
    }

    // /**
    //  * @return Thesaurus[] Returns an array of Thesaurus objects
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
    public function findOneBySomeField($value): ?Thesaurus
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
