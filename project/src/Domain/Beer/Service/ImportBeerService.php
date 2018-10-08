<?php

declare(strict_types=1);

namespace Domain\Beer\Service;

use Domain\Beer\BeerData;
use Domain\Beer\BeerRepositoryInterface;
use Domain\Beer\DuplicatedBeerWasNotCreatedException;
use Domain\Beer\Import\ExternalBeerNotFoundException;
use Domain\Beer\Import\ExternalBeerRepositoryInterface;

final class ImportBeerService
{
    /**
     * @var ExternalBeerRepositoryInterface
     */
    private $externalBeerRepository;

    /**
     * @var BeerRepositoryInterface
     */
    private $beerRepository;

    public function __construct(
        ExternalBeerRepositoryInterface $externalBeerRepository,
        BeerRepositoryInterface $beerRepository
    ) {
        $this->externalBeerRepository = $externalBeerRepository;
        $this->beerRepository = $beerRepository;
    }

    /**
     * @throws ExternalBeerNotFoundException
     */
    public function import(int $numberOfBeers): void
    {
        $externalBeers = $this->externalBeerRepository->fetch($numberOfBeers);

        foreach ($externalBeers as $externalBeer) {
            $beerData = new BeerData(
                $externalBeer->getName(),
                $externalBeer->getDescription(),
                $externalBeer->getAbv(),
                $externalBeer->getIbu(),
                $externalBeer->getImageUrl()
            );

            try {
                $this->beerRepository->createBeer($beerData);
            } catch (DuplicatedBeerWasNotCreatedException $exception) {
                // silently ignore doubles
            }
        }
    }
}
