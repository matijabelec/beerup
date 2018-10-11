<?php

declare(strict_types=1);

namespace Domain\Beer\Browse;

final class SearchTerm
{
    /**
     * @var string
     */
    private $term;

    public function __construct(
        string $term
    ) {
        $this->term = $term;
    }

    public function getTerm(): string
    {
        return $this->term;
    }
}
