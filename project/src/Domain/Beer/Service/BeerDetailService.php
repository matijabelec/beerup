<?php

declare(strict_types=1);

namespace Domain\Beer\Service;

use Domain\Beer\Beer;
use Domain\Beer\BeerId;
use Domain\Beer\BeerNotFoundException;
use Domain\Beer\BeerRepositoryInterface;

final class BeerDetailService
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
    public function fetchById(
        BeerId $beerId
    ): Beer {
        return $this->beerRepository->fetchByBeerId($beerId);
    }
}
