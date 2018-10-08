<?php

declare(strict_types=1);

namespace Domain\Beer;

final class Beer
{
    /**
     * @var BeerId
     */
    private $beerId;

    /**
     * @var BeerData
     */
    private $beerData;

    public function __construct(
        BeerId $beerId,
        BeerData $beerData
    ) {
        $this->beerId = $beerId;
        $this->beerData = $beerData;
    }

    public function getBeerId(): BeerId
    {
        return $this->beerId;
    }

    public function getBeerData(): BeerData
    {
        return $this->beerData;
    }
}
