<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Repository;

use Infrastructure\Doctrine\Entity\Beer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Beer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beer[]    findAll()
 * @method Beer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Beer::class);
    }

    /**
     * @return array [Beer, 'feature_count']
     */
    public function findWithFavoriteCount(
        string $field,
        string $order,
        int $perPage,
        int $offset
    ): array {
        if ($field !== 'favorite_count') {
            $field = sprintf('b.%s', $field);
        }

        return $this->createQueryBuilder('b')
            ->select('b, COUNT(fb.id) as favorite_count')
            ->leftJoin('b.favoriteBeers', 'fb', 'WITH', 'b.id = fb.beer')
            ->orderBy($field, $order)
            ->setFirstResult($offset)
            ->setMaxResults($perPage)
            ->groupBy('b.id')
            ->getQuery()
            ->getResult();
    }
}
