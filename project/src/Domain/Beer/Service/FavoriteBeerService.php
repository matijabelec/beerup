<?php

declare(strict_types=1);

namespace Domain\Beer\Service;

use Domain\Beer\BeerId;
use Domain\Beer\BeerNotFoundException;
use Domain\Beer\FavoriteBeer\BeerAlreadyAddedToFavoriteException;
use Domain\Beer\FavoriteBeer\FavoriteBeerNotFoundException;
use Domain\Beer\FavoriteBeer\FavoriteBeerRepositoryInterface;
use Domain\Beer\FavoriteBeer\UserId;
use Domain\Beer\FavoriteBeer\UserNotFoundException;

final class FavoriteBeerService
{
    /**
     * @var FavoriteBeerRepositoryInterface
     */
    private $favoriteBeerRepository;

    public function __construct(
        FavoriteBeerRepositoryInterface $favoriteBeerRepository
    ) {
        $this->favoriteBeerRepository = $favoriteBeerRepository;
    }

    /**
     * @throws BeerNotFoundException
     * @throws BeerAlreadyAddedToFavoriteException
     * @throws UserNotFoundException
     */
    public function addFavoriteBeer(
        UserId $userId,
        BeerId $beerId
    ): void {
        $this->favoriteBeerRepository->addFavoriteBeer($userId, $beerId);
    }

    /**
     * @throws FavoriteBeerNotFoundException
     */
    public function removeFavoriteBeer(
        UserId $userId,
        BeerId $beerId
    ): void {
        $this->favoriteBeerRepository->removeFavoriteBeer($userId, $beerId);
    }
}
