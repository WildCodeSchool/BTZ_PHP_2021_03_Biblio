<?php

namespace App\Repository;

use App\Entity\Publication;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Publication|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publication|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publication[]    findAll()
 * @method Publication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publication::class);
    }

    /**
     * @param mixed $tabCriteria
     *
     * @return Publication[] Returns an array of Publication objects
     */
    public function findByCriteria($tabCriteria)
    {
        $tab = [
            'type_search' => '=',
            'thematic_search' => '=',
            'author_search' => ['=', 'p.authors', 'a', 'name'],
            'keywordRef_search' => ['=', 'p.keywordRefs', 'kr', 'name'],
            'keywordGeo_search' => ['=', 'p.keywordGeos', 'kg', 'name'],
            'borrow_search' => ['=', 'p.borrows', 'b', 'user'],
            'cote_search' => 'cote',
            'dateStart_search' => '>=',
            'dateEnd_search' => '<=',
        ];

        $kb = $this->createQueryBuilder('p');
        foreach ($tab as $key => $value) {
            if (isset($tabCriteria[$key]) && null !== $tabCriteria[$key]) {
                $field = str_replace('_search', '', $key);

                if (is_array($value)) {
                    $op = ' '.$value[0].' :';
                    $criteria = $value[2].'.'.$value[3].$op.$field;
                    $kb->join($value[1], $value[2]);
                } elseif ('=' === $value) {
                    $op = ' = :';
                    $criteria = 'p.'.$field.$op.$field;
                } elseif ('cote' === $value) {
                    $op = ' = :';
                    $criteria = 'p.cote'.$op.$field;
                } else {
                    $op = ' '.$value.' :';
                    $criteria = 'p.publication_date'.$op.$field;
                }

                $kb->andWhere($criteria);
                $kb->setParameter($field, $tabCriteria[$key]);
            }
        }
        $kb->orderBy('p.title', 'ASC');

        return $kb->getQuery()->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Publication
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByQuery($query)
    {
        $query = "%{$query}%";

        return $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :query')
            ->setParameter('query', $query)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByQueryAuto($query)
    {
        $slugify = new Slugify();
        $query = "%{$slugify->slugify($query)}%";

        return $this->createQueryBuilder('p')
            ->select(['p.id', 'p.title'])
            ->andWhere('p.slug LIKE :query')
            ->setParameter('query', $query)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
}
