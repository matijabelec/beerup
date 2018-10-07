<?php

declare(strict_types=1);

namespace Infrastructure\Beer\Import\Repository;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Domain\Beer\Import\Data\Beer;
use Domain\Beer\Import\Repository\BeerRepositoryInterface;
use Infrastructure\Doctrine\Entity\Beer as BeerEntity;
use Infrastructure\Doctrine\Repository\BeerRepository as DoctrineBeerRepository;

class BeerRepository implements BeerRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var DoctrineBeerRepository
     */
    private $beerRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        DoctrineBeerRepository $beerRepository
    ) {
        $this->entityManager = $entityManager;
        $this->beerRepository = $beerRepository;
    }

    public function addBeer(Beer $beer): void
    {
        $existingBeerEntity = $this->beerRepository->findBy([
            'name' => $beer->getName(),
        ]);

        if (true === empty($existingBeerEntity)) {
            $beerEntity = new BeerEntity();
            $beerEntity
                ->setName($beer->getName())
                ->setDescription($beer->getDescription())
                ->setAbv($beer->getAbv())
                ->setIbu($beer->getIbu())
                ->setImageUrl($beer->getImageUrl());

            $this->entityManager->persist($beerEntity);
            $this->entityManager->flush();
        }
    }
}
