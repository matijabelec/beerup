<?php

declare(strict_types=1);

namespace Infrastructure\Beer;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Beer\Beer;
use Domain\Beer\BeerData;
use Domain\Beer\BeerId;
use Domain\Beer\BeerNotFoundException;
use Domain\Beer\BeerRepositoryInterface;
use Domain\Beer\Browse\BrowseBeerRepositoryInterface;
use Domain\Beer\Browse\OrderByField;
use Domain\Beer\Browse\PageId;
use Domain\Beer\DuplicatedBeerWasNotCreatedException;
use Infrastructure\Doctrine\Entity\Beer as BeerEntity;
use Infrastructure\Doctrine\Repository\BeerRepository as DoctrineBeerRepository;

class BeerRepository implements
    BeerRepositoryInterface,
    BrowseBeerRepositoryInterface
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

    /**
     * @throws BeerNotFoundException
     */
    public function fetchByBeerId(
        BeerId $beerId
    ): Beer {
        $beerEntity = $this->beerRepository->find($beerId->getId());

        if (null === $beerEntity) {
            throw new BeerNotFoundException(
                sprintf('Beer with id %d not found', $beerId->getId())
            );
        }

        $beer = new Beer(
            new BeerId($beerEntity->getId()),
            new BeerData(
                $beerEntity->getName(),
                $beerEntity->getDescription(),
                $beerEntity->getAbv(),
                $beerEntity->getIbu(),
                $beerEntity->getImageUrl()
            )
        );

        return $beer;
    }

    /**
     * @throws DuplicatedBeerWasNotCreatedException
     */
    public function createBeer(
        BeerData $beer
    ): BeerId {
        $existingBeerEntity = $this->beerRepository->findOneBy([
            'name' => $beer->getName(),
        ]);

        if (null !== $existingBeerEntity) {
            throw new DuplicatedBeerWasNotCreatedException();
        }

        $beerEntity = new BeerEntity();
        $beerEntity
            ->setName($beer->getName())
            ->setDescription($beer->getDescription())
            ->setAbv($beer->getAbv())
            ->setIbu($beer->getIbu())
            ->setImageUrl($beer->getImageUrl());

        $this->entityManager->persist($beerEntity);
        $this->entityManager->flush();

        return new BeerId($beerEntity->getId());
    }

    /**
     * @throws BeerNotFoundException
     * @throws DuplicatedBeerWasNotCreatedException
     */
    public function updateBeer(
        BeerId $beerId,
        BeerData $beer
    ): void {
        $beerEntity = $this->beerRepository->find($beerId->getId());

        if (null === $beerEntity) {
            throw new BeerNotFoundException();
        }

        $existingBeerEntity = $this->beerRepository->findOneBy([
            'name' => $beer->getName(),
        ]);

        if ($beerId->getId() !== $existingBeerEntity->getId()) {
            throw new DuplicatedBeerWasNotCreatedException();
        }

        $beerEntity
            ->setName($beer->getName())
            ->setDescription($beer->getDescription())
            ->setAbv($beer->getAbv())
            ->setIbu($beer->getIbu())
            ->setImageUrl($beer->getImageUrl());

        $this->entityManager->persist($beerEntity);
        $this->entityManager->flush();
    }

    /**
     * @throws BeerNotFoundException
     */
    public function removeBeer(
        BeerId $beerId
    ): void {
        $beerEntity = $this->beerRepository->find($beerId->getId());

        if (null === $beerEntity) {
            throw new BeerNotFoundException();
        }

        $this->entityManager->remove($beerEntity);
        $this->entityManager->flush();
    }

    /**
     * @return Beer[]
     */
    public function browse(
        OrderByField $orderByField,
        PageId $pageId
    ): array {
        $perPage = 20;

        $currentPage = $pageId->getId() - 1;
        $offset = $currentPage * $perPage;

        $beerEntites = $this->beerRepository->findBy([], [
            $orderByField->getField() => $orderByField->getOrder()
        ], $perPage, $offset);

        $beers = [];
        foreach ($beerEntites as $beerEntity) {
            $beers[] = new Beer(
                new BeerId($beerEntity->getId()),
                new BeerData(
                    $beerEntity->getName(),
                    $beerEntity->getDescription(),
                    $beerEntity->getAbv(),
                    $beerEntity->getIbu(),
                    $beerEntity->getImageUrl()
                )
            );
        }

        return $beers;
    }
}
