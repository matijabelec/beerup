<?php

declare(strict_types=1);

namespace Application\Http;

use Application\JsonApiControllerInterface;
use Application\Request\RequestContentValidator;
use Application\Security\Gate;
use Application\TokenAuthenticatedControllerInterface;
use Domain\Beer\Beer;
use Domain\Beer\BeerId;
use Domain\Beer\Browse\UserId;
use Domain\Beer\FavoriteBeer\UserId as FavoriteBeerUserId;
use Domain\Beer\Service\BrowseBeerService;
use Domain\Beer\Service\FavoriteBeerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/favorite-beers")
 */
final class FavoriteBeersController implements
    JsonApiControllerInterface,
    TokenAuthenticatedControllerInterface
{
    private const FAVORITE_BEER_RESOURCE_FIELDS = [
        'beer_id',
    ];

    /**
     * @var Gate
     */
    private $gate;

    public function __construct(
        Gate $gate
    ) {
        $this->gate = $gate;
    }


    /**
     * @Route(methods={"GET"})
     * @return Beer[]
     */
    public function collection(
        BrowseBeerService $browseBeerService
    ): array {
        $this->gate->validatePermissions(['ROLE_USER']);

        $userId = $this->gate->getAuthUserId();
        return $browseBeerService->browseFavoriteBeers(new UserId($userId));
    }

    /**
     * @Route(methods={"POST"})
     */
    public function add(
        FavoriteBeerService $favoriteBeerService,
        RequestContentValidator $requestContentValidator,
        Request $request
    ): void {
        $this->gate->validatePermissions(['ROLE_USER']);

        $data = $requestContentValidator
            ->validateData($request->getContent(), self::FAVORITE_BEER_RESOURCE_FIELDS);
        $userId = $this->gate->getAuthUserId();
        $beerId = (int) $data['beer_id'];
        $favoriteBeerService->addFavoriteBeer(new FavoriteBeerUserId($userId), new BeerId($beerId));
    }

    /**
     * @Route("/{beerId}", methods={"DELETE"})
     */
    public function remove(
        FavoriteBeerService $favoriteBeerService,
        int $beerId
    ): void {
        $this->gate->validatePermissions(['ROLE_USER']);

        $userId = $this->gate->getAuthUserId();
        $favoriteBeerService->removeFavoriteBeer(new FavoriteBeerUserId($userId), new BeerId($beerId));
    }
}
