<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Classes\Search;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    /**
     * Request render  data based on Search
     * @return Products[] Returns an array of Products objects
     */
    public function findWithSearch(Search $search){

        // query with join
        $query = $this->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.category', 'c');

        // serch by category
        if(!empty($search->categories)){
            $query = $query
            ->andWhere('c.id in (:categories)')
            ->setParameter('categories', $search->categories);
        }

        // serch by name of product
        if(!empty($search->string)){
            $query = $query
            ->andWhere('p.name Like :string')
            ->setParameter('string',"%{$search->string}%");
        }

        return $query->getQuery() ->getResult();

    }

    // /**
    //  * @return Products[] Returns an array of Products objects
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
    public function findOneBySomeField($value): ?Products
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
