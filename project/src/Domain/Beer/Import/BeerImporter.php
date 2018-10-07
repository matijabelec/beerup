<?php

declare(strict_types=1);

namespace Domain\Beer\Import;

use Domain\Beer\Import\Repository\BeerRepositoryInterface;
use Domain\Beer\Import\Repository\ExternalBeerRepositoryInterface;

final class BeerImporter
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

    public function import(int $count): void
    {
        $beers = $this->externalBeerRepository->find($count);

        foreach ($beers as $beer) {
            $this->beerRepository->addBeer($beer);
        }
    }
}
