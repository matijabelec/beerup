<?php

namespace Domain\Beer\Import;

interface ExternalBeerRepositoryInterface
{
    /**
     * @return ExternalBeer[]
     * @throws ExternalBeerNotFoundException
     */
    public function fetch(int $numberOfBeers): array;
}
