<?php

namespace Application\Security;

use Exception;
use Prophecy\Doubler\ClassPatch\ThrowablePatch;

final class UnauthorizedException extends Exception
{
    public function __construct(
        $message = 'Unauthorized request',
        $code = 100000,
        ThrowablePatch $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
