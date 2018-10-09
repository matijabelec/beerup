<?php

declare(strict_types=1);

namespace Domain\Beer\FavoriteBeer;

use Exception;
use Throwable;

class BeerAlreadyAddedToFavoriteException extends Exception
{
    public function __construct(
        $message = 'Beer already added to favorite',
        $code = 3,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
