<?php

namespace App\Repository;

use App\Entity\Publication;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;


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
    * @return Publication[] Returns an array of Publication objects
    */

    public function findByCriteria($tabCriteria)
    {
        $tab = [
            'type_search' => '=',
            'thematic_search' => '=',
            'author_search' => ['=', 'p.authors', 'a'],
            'keyword_search' => ['=', 'p.keywords', 'k'],
            'dateStart_search' => '>=',
            'dateEnd_search' => '<=',
        ];
        
        $kb = $this->createQueryBuilder('p');
        foreach ($tab as $key => $value) {
            if (isset($tabCriteria[$key])) {
                $field = str_replace('_search', '', $key);
                
                if (is_array($value)) {
                    $op = " " . $value[0] .  " :";
                    $criteria = $value[2] . ".name" . $op . $field;
                    $kb->join($value[1], $value[2]);
                } elseif ($value === '=') {
                    $op = " = :";
                    $criteria = "p." . $field . $op . $field;
                } else {
                    $op = " " . $value . " :";
                    $criteria = "p.publication_date" . $op . $field;
                };
                
                $kb->andWhere($criteria);
                $kb->setParameter($field, $tabCriteria[$key]);
            }
        }
        $kb->orderBy('p.title', 'ASC');
        return $kb->getQuery()->getResult();
        
        
        // $paginator = new PaginatorInterface();
        // $request = new Request();
        // $pagination = $paginator->paginate(
        //     $kb, /* query NOT result */
        //     $request->query->getInt('page', 1), /*page number*/
        //     10 /*limit per page*/
        // );

        // return $pagination;

    

        // return $this->createQueryBuilder('p')
        //     // ->Join('p.keywords', 'k')
        //     // ->Join('p.authors', 'a')
        //     // ->Where('p.type = :type')
        //     // ->andWhere('p.thematic = :thematic')
        //     // ->andWhere('a.name = :author')
        //     // ->andWhere('k.name = :keyword')
        //     ->andWhere(':datePub > :dateStart')
        //     // ->setParameter('type', $tabCriteria['type_search'])
        //     // ->setParameter('thematic', $tabCriteria['thematic_search'])
        //     // ->setParameter('author', $tabCriteria['author_search'])
        //     // ->setParameter('keyword', $tabCriteria['keyword_search'])
        //     ->setParameter('datePub', 'p.publication_date')
        //     ->setParameter('dateStart', new dateTime($tabCriteria['dateStart_search']))
            
        //     ->orderBy('p.title', 'ASC')
        //     ->setMaxResults(10)
        //     ->getQuery()
        //     ->getResult()
        // ;
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
}
