<?php

declare(strict_types=1);

namespace Domain\Beer\Service;

use Domain\Beer\Beer;
use Domain\Beer\Browse\BrowseBeerRepositoryInterface;
use Domain\Beer\Browse\OrderByField;
use Domain\Beer\Browse\PageId;
use Domain\Beer\Browse\UserId;

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
        PageId $pageId
    ): array {
        return $this->browseBeerRepository->browse($orderByField, $pageId);
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
