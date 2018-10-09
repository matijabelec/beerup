<?php

namespace Infrastructure\Doctrine\Repository;

use Infrastructure\Doctrine\Entity\FavoriteBeer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Infrastructure\Doctrine\Entity\User;
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

    /**
     * @return FavoriteBeer[]
     */
    public function findByUserIdOrderedByTimeAddedDesc(int $userId): array
    {
        $user = $this->getEntityManager()->getReference(User::class, $userId);
        return $this->createQueryBuilder('fb')
            ->andWhere('fb.user = :user')
            ->leftJoin('fb.beer', 'b')
            ->setParameter('user', $user)
            ->orderBy('fb.timeAdded', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array [user_id, beer_name]
     */
    public function findAllFavoriteBeerNamesPerUsers(): array
    {
        return $this->createQueryBuilder('fb')
            ->select('u.id as user_id, b.name as beer_name')
            ->join('fb.user', 'u')
            ->leftJoin('fb.beer', 'b')
            ->groupBy('u.id, b.name')
            ->getQuery()
            ->getResult();
    }
}
