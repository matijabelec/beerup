<?php

declare(strict_types=1);

namespace Application\Resource;

use Domain\Beer\Beer;

final class BeerResource implements ResourceInterface
{
    /**
     * @var Beer
     */
    private $beer;

    public function __construct(
        Beer $beer
    ) {
        $this->beer = $beer;
    }

    public function getType(): string
    {
        return 'beers';
    }

    public function getId(): string
    {
        return (string) $this->beer->getBeerId()->getId();
    }

    public function getAttributes(): array
    {
        $beerData = $this->beer->getBeerData();
        return [
            'name' => $beerData->getName(),
            'description' => $beerData->getDescription(),
            'abv' => $beerData->getAbv(),
            'ibu' => $beerData->getIbu(),
            'image_url' => $beerData->getImageUrl(),
        ];
    }
}
