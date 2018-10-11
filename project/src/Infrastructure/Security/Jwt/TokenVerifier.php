<?php

declare(strict_types=1);

namespace Infrastructure\Security\Jwt;

use Application\Security\Jwt\Token;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

final class TokenVerifier
{
    /**
     * @var string
     */
    private $privateKey;

    /**
     * @var string
     */
    private $host;

    public function __construct(
        string $privateKey,
        string $host
    ) {
        $this->privateKey = $privateKey;
        $this->host = $host;
    }

    public function verify(Token $token): bool
    {
        $signer = new Sha256();
        $parser = new Parser();

        $token = $parser->parse($token->getEncoded());

        if (false === $token->verify($signer, $this->privateKey)) {
            return false;
        }

        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer($this->host);
        $data->setAudience($this->host);

        return $token->validate($data);
    }
}
