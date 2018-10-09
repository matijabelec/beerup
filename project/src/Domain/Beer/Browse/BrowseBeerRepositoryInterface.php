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
        PageId $pageId
    ): array;
}