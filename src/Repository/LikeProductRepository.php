<?php

namespace App\Repository;

use App\Entity\LikeProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LikeProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method LikeProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method LikeProduct[]    findAll()
 * @method LikeProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LikeProduct::class);
    }

    // /**
    //  * @return LikeProduct[] Returns an array of LikeProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LikeProduct
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByUserIdAndProductId(int $userId, int  $productId){

        return $this->createQueryBuilder('l')
            ->andWhere('l.user = :userId')
            ->andWhere('l.product = :productId')
            ->setParameters([
                'userId'    => $userId,
                'productId' => $productId
            ])
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}
