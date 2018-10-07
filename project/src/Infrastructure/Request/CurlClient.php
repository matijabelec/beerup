<?php

declare(strict_types=1);

namespace Infrastructure\Request;

use Curl\Curl;
use Exception;

class CurlClient
{
    /**
     * @throws Exception on unsuccessful request
     */
    public function get(string $url): string
    {
        $curl = new Curl();
        $curl->get($url);

        if ($curl->error) {
            throw new Exception($curl->curl_error_message);
        }

        return $curl->response;
    }
}
