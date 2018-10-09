<?php

declare(strict_types=1);

namespace Domain\Beer;

final class BeerStatsData
{
    /**
     * @var int
     */
    private $favoriteCount;

    public function __construct(
        int $favoriteCount
    ) {
        $this->favoriteCount = $favoriteCount;
    }

    public function getFavoriteCount(): int
    {
        return $this->favoriteCount;
    }
}
