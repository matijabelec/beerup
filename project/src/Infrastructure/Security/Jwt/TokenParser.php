<?php

namespace Infrastructure\Security\Jwt;

use Application\Security\Jwt\Token;
use Lcobucci\JWT\Parser;

final class TokenParser
{
    public function parse(string $payload): Token
    {
        $parser = new Parser();

        $token = $parser->parse($payload);
        $userId = (int) $token->getClaim('uid');

        return new Token((string) $token, $userId);
    }
}
