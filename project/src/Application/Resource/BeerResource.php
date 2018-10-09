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

    public function getAttributes(array $fields = []): array
    {
        $beerData = $this->beer->getBeerData();
        $attributes = [
            'name' => $beerData->getName(),
            'description' => $beerData->getDescription(),
            'abv' => $beerData->getAbv(),
            'ibu' => $beerData->getIbu(),
            'image_url' => $beerData->getImageUrl(),
        ];

        $attributes = array_filter(
            $attributes,
            function ($key) use ($fields) {
                return in_array($key, $fields, true);
            },
            ARRAY_FILTER_USE_KEY
        );

        if (in_array('favorite_count', $fields, true)) {
            $attributes['favorite_count'] = $this->beer->getBeerStatsData()->getFavoriteCount();
        }

        return $attributes;
    }
}
