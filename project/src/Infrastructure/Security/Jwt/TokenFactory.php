<?php

declare(strict_types=1);

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

    public function create(int $userId): Token
    {
        $signer = new Sha256();
        $builder = new Builder();

        $token = $builder->setIssuer($this->host)
            ->setAudience($this->host)
            ->setIssuedAt(time())
            ->setNotBefore(time() + 1)
            ->setExpiration(time() + 1800)
            ->set('uid', $userId)
            ->sign($signer, $this->privateKey)
            ->getToken();

        return new Token((string) $token, $userId);
    }
}
