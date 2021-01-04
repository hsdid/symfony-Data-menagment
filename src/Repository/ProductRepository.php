<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function productDescLikes() {

        $qb = $this->createQueryBuilder('p')
        ->select('COUNT(u) AS HIDDEN nbrLikes', 'p')
        ->leftJoin('p.likes', 'u') 
        ->orderBy('nbrLikes', 'DESC')
        ->groupBy('p')
        ->getQuery()
        ->getResult()
    ;

    return $qb;
    }

    public function productASCLikes() {

        $qb = $this->createQueryBuilder('p')
        ->select('COUNT(u) AS HIDDEN nbrLikes', 'p')
        ->leftJoin('p.likes', 'u') 
        ->orderBy('nbrLikes', 'ASC')
        ->groupBy('p')
        ->getQuery()
        ->getResult()
    ;

    return $qb;
    }


    public function findByUserProductDescLikes(int $userId) {

        $qb = $this->createQueryBuilder('p')
        ->select('COUNT(u) AS HIDDEN nbrLikes', 'p')
        ->where('p.user =?1')
        ->leftJoin('p.likes', 'u') 
        ->orderBy('nbrLikes', 'DESC')
        ->groupBy('p')
        ->setParameter('1', $userId)
        ->getQuery()
        ->getResult()
    ;

    return $qb;
    }

    public function findByUserProductASCLikes(int $userId) {

        $qb = $this->createQueryBuilder('p')
        ->select('COUNT(u) AS HIDDEN nbrLikes', 'p')
        ->leftJoin('p.likes', 'u') 
        
        ->orderBy('nbrLikes', 'ASC')
        ->groupBy('p')
        ->where('p.user =?1')
        ->setParameter('1', $userId)
        ->getQuery()
        ->getResult()
    ;

    return $qb;
    }

}
