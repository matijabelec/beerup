<?php

declare(strict_types=1);

namespace Domain\Beer\Service;

use Domain\Beer\BeerData;
use Domain\Beer\BeerNotFoundException;
use Domain\Beer\BeerRepositoryInterface;
use Domain\Beer\BeerId;
use Domain\Beer\DuplicatedBeerWasNotCreatedException;
use Domain\Beer\InvalidBeerDataException;
use Domain\Beer\Specification\BeerDataIsValidSpecification;

final class SaveBeerService
{
    /**
     * @var BeerRepositoryInterface
     */
    private $beerRepository;

    /**
     * @var BeerDataIsValidSpecification
     */
    private $beerDataIsValidSpecification;

    public function __construct(
        BeerRepositoryInterface $beerRepository,
        BeerDataIsValidSpecification $beerDataIsValidSpecification
    ) {
        $this->beerRepository = $beerRepository;
        $this->beerDataIsValidSpecification = $beerDataIsValidSpecification;
    }

    /**
     * @throws InvalidBeerDataException
     * @throws DuplicatedBeerWasNotCreatedException
     */
    public function createBeer(array $data): BeerId
    {
        $beerData = $this->convertToBeerData($data);
        return $this->beerRepository->createBeer($beerData);
    }

    /**
     * @throws BeerNotFoundException
     * @throws InvalidBeerDataException
     */
    public function updateBeer(BeerId $beerId, array $data): void
    {
        $beerData = $this->convertToBeerData($data);
        $this->beerRepository->updateBeer($beerId, $beerData);
    }

    /**
     * @throws InvalidBeerDataException
     */
    private function convertToBeerData(array $data): BeerData
    {
        if (false === $this->beerDataIsValidSpecification->isSatisfiedBy($data)) {
            throw new InvalidBeerDataException();
        }

        $beerData = new BeerData(
            (string) $data['name'],
            isset($data['description']) ? (string) $data['description'] : null,
            (float) $data['abv'],
            isset($data['ibu']) ? (float) $data['ibu'] : null,
            isset($data['imageUrl']) ? (float) $data['imageUrl'] : null
        );

        return $beerData;
    }
}
