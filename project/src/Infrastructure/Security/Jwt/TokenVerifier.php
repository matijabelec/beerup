<?php

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

    public function __construct(
        string $privateKey
    ) {
        $this->privateKey = $privateKey;
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
        $data->setIssuer('http://api.loc');
        $data->setAudience('http://api.loc');
        $data->setId('aa1g23e123a');

        return $token->validate($data);
    }
}
