<?php

declare(strict_types=1);

namespace Domain\Beer;

use Exception;
use Throwable;

class DuplicatedBeerWasNotCreatedException extends Exception
{
    public function __construct(
        $message = 'Duplicate Beer',
        $code = 3,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
