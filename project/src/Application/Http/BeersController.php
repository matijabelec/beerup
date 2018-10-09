<?php

declare(strict_types=1);

namespace Application\Http;

use Application\JsonApiControllerInterface;
use Application\Request\RequestContentValidator;
use Application\Response\Response;
use Application\TokenAuthenticatedControllerInterface;
use Domain\Beer\Beer;
use Domain\Beer\BeerId;
use Domain\Beer\Browse\OrderByField;
use Domain\Beer\Browse\PageId;
use Domain\Beer\Service\BeerDetailService;
use Domain\Beer\Service\BrowseBeerService;
use Domain\Beer\Service\RemoveBeerService;
use Domain\Beer\Service\SaveBeerService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/beers")
 */
final class BeersController implements
    JsonApiControllerInterface,
    TokenAuthenticatedControllerInterface
{
    private const BEER_RESOURCE_FIELDS = [
        'name',
        'description',
        'abv',
        'ibu',
        'image_url',
    ];

    /**
     * @Route(methods={"GET"})
     * @return Beer[]
     */
    public function collection(
        BrowseBeerService $browseBeerService,
        Request $request
    ): Response {
        $orderByField = (string) $request->query->get('orderBy', 'id');
        $page = (int) $request->query->get('page', 1);

        $beers = $browseBeerService->browse(new OrderByField($orderByField), new PageId($page));
        $fields = array_unique([ 'name', 'abv', 'ibu', ltrim($orderByField, '-'), ]);
        return new Response($beers, $fields);
    }

    /**
     * @Route(methods={"POST"})
     */
    public function create(
        SaveBeerService $saveBeerService,
        RequestContentValidator $requestContentValidator,
        Request $request
    ): JsonResponse {
        $data = $requestContentValidator
            ->validateData($request->getContent(), self::BEER_RESOURCE_FIELDS);
        $beerId = $saveBeerService->createBeer($data);

        return new JsonResponse(null, 201, [
            'Location' => sprintf('/beers/%d', $beerId->getId()),
        ]);
    }

    /**
     * @Route("/{beerId}", methods={"GET"})
     */
    public function fetch(
        BeerDetailService $beerDetailService,
        int $beerId
    ): Beer {
        return $beerDetailService->fetchById(new BeerId($beerId));
    }

    /**
     * @Route("/{beerId}", methods={"PUT"})
     */
    public function update(
        SaveBeerService $saveBeerService,
        RequestContentValidator $requestContentValidator,
        Request $request,
        int $beerId
    ): JsonResponse {
        $data = $requestContentValidator
            ->validateData($request->getContent(), self::BEER_RESOURCE_FIELDS);
        $saveBeerService->updateBeer(new BeerId($beerId), $data);

        return new JsonResponse(null, 204);
    }

    /**
     * @Route("/{beerId}", methods={"DELETE"})
     */
    public function remove(
        RemoveBeerService $removeBeerService,
        int $beerId
    ): JsonResponse {
        $removeBeerService->removeBeer(new BeerId($beerId));

        return new JsonResponse(null, 204);
    }
}
