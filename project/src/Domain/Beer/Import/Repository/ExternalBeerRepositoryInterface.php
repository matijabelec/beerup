<?php

namespace Domain\Beer\Import\Repository;

use Domain\Beer\Import\Data\Beer;
use Domain\Beer\Import\Exception\ExternalBeersWasNotReadable;

interface ExternalBeerRepositoryInterface
{
    /**
     * @return Beer[]
     * @throws ExternalBeersWasNotReadable
     */
    public function find(int $count): array;
}
