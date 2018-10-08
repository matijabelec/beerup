<?php

declare(strict_types=1);

namespace Domain\Beer\Service;

use Domain\Beer\BeerId;
use Domain\Beer\BeerNotFoundException;
use Domain\Beer\BeerRepositoryInterface;

final class RemoveBeerService
{
    /**
     * @var BeerRepositoryInterface
     */
    private $beerRepository;

    public function __construct(
        BeerRepositoryInterface $beerRepository
    ) {
        $this->beerRepository = $beerRepository;
    }

    /**
     * @throws BeerNotFoundException
     */
    public function removeBeer(BeerId $beerId): void
    {
        $this->beerRepository->removeBeer($beerId);
    }
}
