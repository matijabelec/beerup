<?php

declare(strict_types=1);

namespace Domain\Beer\Service;

use Domain\Beer\Beer;
use Domain\Beer\Browse\BrowseBeerRepositoryInterface;
use Domain\Beer\Browse\OrderByField;
use Domain\Beer\Browse\PageId;

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
}
