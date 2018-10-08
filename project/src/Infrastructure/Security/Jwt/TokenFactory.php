<?php

namespace Infrastructure\Security\Jwt;

use Application\Security\Jwt\Token;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

final class TokenFactory
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

    public function create(int $userId): Token
    {
        $signer = new Sha256();
        $builder = new Builder();

        $token = $builder->setIssuer('http://api.loc')
            ->setAudience('http://api.loc')
            ->setId('aa1g23e123a', true)
            ->setIssuedAt(time())
            ->setNotBefore(time() + 1)
            ->setExpiration(time() + 1800)
            ->set('uid', $userId)
            ->sign($signer, $this->privateKey)
            ->getToken();

        return new Token((string) $token, $userId);
    }
}
