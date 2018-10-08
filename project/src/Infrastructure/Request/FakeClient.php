<?php

declare(strict_types=1);

namespace Infrastructure\Request;

use Exception;

class FakeClient implements ClientInterface
{
    /**
     * @throws Exception on unsuccessful request
     */
    public function get(string $url): string
    {
        throw new Exception();
    }
}
