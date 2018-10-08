<?php

declare(strict_types=1);

namespace Domain\Beer\Search;

use Domain\Beer\Beer;
use LogicException;

final class SearchBeerResult
{
    /**
     * @var Beer[]
     */
    private $beers;

    /**
     * @param Beer[] $beerIds
     */
    public function __construct(
        array $beers
    ) {
        foreach ($beers as $beer) {
            if (false === ($beer instanceof Beer)) {
                throw new LogicException('List MUST contain elements of type BeerId');
            }
        }
        $this->beers = $beers;
    }

    /**
     * @return Beer[]
     */
    public function getBeerIds(): array
    {
        return $this->beers;
    }
}
