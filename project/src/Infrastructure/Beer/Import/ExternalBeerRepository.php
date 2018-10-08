<?php

declare(strict_types=1);

namespace Infrastructure\Beer\Import;

use Domain\Beer\Import\ExternalBeer;
use Domain\Beer\Import\ExternalBeerNotFoundException;
use Domain\Beer\Import\ExternalBeerRepositoryInterface;
use Exception;
use Infrastructure\Request\ClientInterface;

final class ExternalBeerRepository implements ExternalBeerRepositoryInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $url = 'https://api.punkapi.com/v2/beers';

    public function __construct(
        ClientInterface $client
    ) {
        $this->client = $client;
    }

    /**
     * @return ExternalBeer[]
     * @throws ExternalBeerNotFoundException
     */
    public function fetch(int $numberOfBeers): array
    {
        $url = sprintf('%s?per_page=%d', $this->url, $numberOfBeers);

        try {
            $jsonResponse = $this->client->get($url);
        } catch (Exception $exception) {
            throw new ExternalBeerNotFoundException();
        }

        $items = json_decode($jsonResponse, true);

        $beers = [];
        foreach ($items as $item) {
            $name = $item['name'] ?? 'Unknown';
            $description = $item['description'] ?? null;
            $abv = $item['abv'] ?? 0;
            $ibu = $item['ibu'] ?? null;
            $imageUrl = $item['image_url'] ?? null;

            $beers[] = new ExternalBeer(
                $name,
                $description,
                $abv,
                $ibu,
                $imageUrl
            );
        }

        return $beers;
    }
}
