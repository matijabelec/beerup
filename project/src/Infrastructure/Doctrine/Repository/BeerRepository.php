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
        string $searchTerm,
        int $perPage,
        int $offset
    ): array {
        if ($field !== 'favorite_count') {
            $field = sprintf('b.%s', $field);
        }

        $qb = $this->createQueryBuilder('b')
            ->select('b, COUNT(fb.id) as favorite_count')
            ->leftJoin('b.favoriteBeers', 'fb', 'WITH', 'b.id = fb.beer')
            ->orderBy($field, $order)
            ->setFirstResult($offset)
            ->setMaxResults($perPage)
            ->groupBy('b.id');

        if ('' !== $searchTerm) {
            $searchTerm = sprintf(
                '%%%s%%',
                preg_replace('/[^a-zA-Z0-9\.\*\+\\n|#;:!"%@{} _-]/', '', $searchTerm)
            );

            $qb->having('b.name LIKE :name')
                ->orHaving('b.description LIKE :description')
                ->orHaving('b.abv LIKE :abv')
                ->orHaving('b.ibu LIKE :ibu')
                ->orHaving('b.imageUrl LIKE :image_url')
                ->setParameters([
                    'name' => $searchTerm,
                    'description' => $searchTerm,
                    'abv' => $searchTerm,
                    'ibu' => $searchTerm,
                    'image_url' => $searchTerm,
                ]);
        }

        return $qb->getQuery()
            ->getResult();
    }
}
