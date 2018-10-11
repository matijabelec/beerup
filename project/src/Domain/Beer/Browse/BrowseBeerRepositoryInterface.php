<?php

namespace Domain\Beer\Browse;

use Domain\Beer\Beer;

interface BrowseBeerRepositoryInterface
{
    /**
     * @return Beer[]
     */
    public function browse(
        OrderByField $orderByField,
        PageId $pageId,
        SearchTerm $searchTerm
    ): array;

    /**
     * @return Beer[]
     */
    public function browseFavoritedBeers(
        UserId $userId
    ): array;
}
