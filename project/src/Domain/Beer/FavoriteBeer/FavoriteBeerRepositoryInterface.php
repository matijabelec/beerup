<?php

namespace Domain\Beer\FavoriteBeer;

use Domain\Beer\BeerId;
use Domain\Beer\BeerNotFoundException;

interface FavoriteBeerRepositoryInterface
{
    /**
     * @throws BeerAlreadyAddedToFavoriteException
     * @throws BeerNotFoundException
     * @throws UserNotFoundException
     */
    public function addFavoriteBeer(
        UserId $userId,
        BeerId $beerId
    ): void;

    /**
     * @throws FavoriteBeerNotFoundException
     */
    public function removeFavoriteBeer(
        UserId $userId,
        BeerId $beerId
    ): void;
}
