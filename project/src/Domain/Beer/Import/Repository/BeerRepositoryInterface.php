<?php

namespace Domain\Beer\Import\Repository;

use Domain\Beer\Import\Data\Beer;

interface BeerRepositoryInterface
{
    public function addBeer(Beer $beer): void;
}
