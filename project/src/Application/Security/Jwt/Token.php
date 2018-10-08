<?php

namespace Application\Security\Jwt;

final class Token
{
    /**
     * @var string
     */
    private $encoded;

    /**
     * @var int
     */
    private $userId;

    public function __construct(
        string $encoded,
        int $userId
    ) {
        $this->encoded = $encoded;
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getEncoded(): string
    {
        return $this->encoded;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
