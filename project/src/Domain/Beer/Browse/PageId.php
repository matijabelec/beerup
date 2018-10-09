<?php

declare(strict_types=1);

namespace Domain\Beer\Browse;

final class PageId
{
    /**
     * @var int
     */
    private $id;

    public function __construct(
        int $id
    ) {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}