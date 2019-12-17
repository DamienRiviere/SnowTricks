<?php

namespace App\Repository;

use App\Entity\TrickLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TrickLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickLike[]    findAll()
 * @method TrickLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrickLike::class);
    }

    // /**
    //  * @return TrickLike[] Returns an array of TrickLike objects
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
    public function findOneBySomeField($value): ?TrickLike
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
