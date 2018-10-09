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

    /**
     * @var BeerStatsData
     */
    private $beerStatsData;

    public function __construct(
        BeerId $beerId,
        BeerData $beerData,
        BeerStatsData $beerStatsData
    ) {
        $this->beerId = $beerId;
        $this->beerData = $beerData;
        $this->beerStatsData = $beerStatsData;
    }

    public function getBeerId(): BeerId
    {
        return $this->beerId;
    }

    public function getBeerData(): BeerData
    {
        return $this->beerData;
    }

    public function getBeerStatsData(): BeerStatsData
    {
        return $this->beerStatsData;
    }
}
