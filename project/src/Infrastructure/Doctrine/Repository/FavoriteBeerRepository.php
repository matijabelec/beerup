<?php

namespace Infrastructure\Doctrine\Repository;

use Infrastructure\Doctrine\Entity\FavoriteBeer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FavoriteBeer|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavoriteBeer|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavoriteBeer[]    findAll()
 * @method FavoriteBeer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteBeerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FavoriteBeer::class);
    }

//    /**
//     * @return FavoriteBeer[] Returns an array of FavoriteBeer objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FavoriteBeer
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
