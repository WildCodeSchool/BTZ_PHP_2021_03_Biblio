<?php

namespace App\Repository;

use App\Entity\Borrow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Borrow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Borrow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Borrow[]    findAll()
 * @method Borrow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BorrowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borrow::class);
    }


    public function findLikeCote($cote)
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('publication', 'p', 'ON', 'p.id = b.publication_id')
            ->andWhere('p.cote LIKE :cote')
            ->setParameter('cote', '%' . $cote . '%')
            ->getQuery()
            ->getResult()
        ;
    }


    

}
