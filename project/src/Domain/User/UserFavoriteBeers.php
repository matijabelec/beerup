<?php

declare(strict_types=1);

namespace Domain\User;

final class UserFavoriteBeers
{
    /**
     * @var string[]
     */
    private $beerNames;

    /**
     * @param string[] $beerNames
     */
    public function __construct(
        array $beerNames
    ) {
        $this->beerNames = $beerNames;
    }

    /**
     * @return string[]
     */
    public function getBeerNames(): array
    {
        return $this->beerNames;
    }
}
