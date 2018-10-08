<?php

declare(strict_types=1);

namespace Domain\Beer\Import;

final class ExternalBeer
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var null|string
     */
    private $description;

    /**
     * @var float
     */
    private $abv;

    /**
     * @var float|null
     */
    private $ibu;

    /**
     * @var null|string
     */
    private $imageUrl;

    public function __construct(
        string $name,
        ?string $description,
        float $abv,
        ?float $ibu,
        ?string $imageUrl
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->abv = $abv;
        $this->ibu = $ibu;
        $this->imageUrl = $imageUrl;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getAbv(): float
    {
        return $this->abv;
    }

    public function getIbu(): ?float
    {
        return $this->ibu;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }
}
