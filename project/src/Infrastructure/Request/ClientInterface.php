<?php

namespace Infrastructure\Request;

use Exception;

interface ClientInterface
{
    /**
     * @throws Exception on unsuccessful request
     */
    public function get(string $url): string;
}
