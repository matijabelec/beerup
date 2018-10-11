<?php

declare(strict_types=1);

namespace Domain\Beer\Service;

use Domain\Beer\Beer;
use Domain\Beer\Browse\BrowseBeerRepositoryInterface;
use Domain\Beer\Browse\OrderByField;
use Domain\Beer\Browse\PageId;
use Domain\Beer\Browse\UserId;
use Domain\Beer\Browse\SearchTerm;

final class BrowseBeerService
{
    /**
     * @var BrowseBeerRepositoryInterface
     */
    private $browseBeerRepository;

    public function __construct(
        BrowseBeerRepositoryInterface $browseBeerRepository
    ) {
        $this->browseBeerRepository = $browseBeerRepository;
    }

    /**
     * @return Beer[]
     */
    public function browse(
        OrderByField $orderByField,
        PageId $pageId,
        SearchTerm $searchTerm
    ): array {
        return $this->browseBeerRepository->browse($orderByField, $pageId, $searchTerm);
    }

    /**
     * @return Beer[]
     */
    public function browseFavoriteBeers(
        UserId $userId
    ): array {
        return $this->browseBeerRepository->browseFavoritedBeers($userId);
    }
}
