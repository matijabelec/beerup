<?php

declare(strict_types=1);

namespace Domain\Beer;

use Exception;
use Throwable;

class BeerNotFoundException extends Exception
{
    public function __construct(
        $message = '',
        $code = 1,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
