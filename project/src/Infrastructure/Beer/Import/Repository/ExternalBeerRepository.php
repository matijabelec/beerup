<?php

declare(strict_types=1);

namespace Infrastructure\Beer\Import\Repository;

use Domain\Beer\Import\Data\Beer;
use Domain\Beer\Import\Exception\ExternalBeersWasNotReadable;
use Domain\Beer\Import\Repository\ExternalBeerRepositoryInterface;
use Exception;
use Infrastructure\Request\CurlClient;

final class ExternalBeerRepository implements ExternalBeerRepositoryInterface
{
    /**
     * @var CurlClient
     */
    private $client;

    /**
     * @var string
     */
    private $url = 'https://api.punkapi.com/v2/beers';

    public function __construct(
        CurlClient $client
    ) {
        $this->client = $client;
    }

    /**
     * @return Beer[]
     * @throws ExternalBeersWasNotReadable
     */
    public function find(int $count): array
    {
        $url = sprintf('%s?per_page=%d', $this->url, $count);

        try {
            $jsonResponse = $this->client->get($url);
        } catch (Exception $exception) {
            throw new ExternalBeersWasNotReadable();
        }

        $items = json_decode($jsonResponse, true);

        $beers = [];
        foreach ($items as $item) {
            $name = $item['name'] ?? 'Unknown';
            $description = $item['description'] ?? null;
            $abv = $item['abv'] ?? 0;
            $ibu = $item['ibu'] ?? null;
            $imageUrl = $item['image_url'] ?? null;

            $beers[] = new Beer(
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
