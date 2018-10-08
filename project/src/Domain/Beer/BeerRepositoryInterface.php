<?php

namespace Domain\Beer;

interface BeerRepositoryInterface
{
    /**
     * @throws BeerNotFoundException
     */
    public function fetchByBeerId(BeerId $beerId): Beer;

    /**
     * @throws DuplicatedBeerWasNotCreatedException
     */
    public function createBeer(BeerData $beer): BeerId;

    /**
     * @throws BeerNotFoundException
     */
    public function updateBeer(BeerId $beerId, BeerData $beer): void;

    /**
     * @throws BeerNotFoundException
     */
    public function removeBeer(BeerId $beerId): void;
}
