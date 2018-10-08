<?php

declare(strict_types=1);

namespace Application\Resource;

use Application\Security\Jwt\Token;

final class TokenResource implements ResourceInterface
{
    /**
     * @var Token
     */
    private $token;

    public function __construct(
        Token $token
    ) {
        $this->token = $token;
    }

    public function getType(): string
    {
        return 'tokens';
    }

    public function getId(): string
    {
        return '0';
    }

    public function getAttributes(): array
    {
        return [
            'token' => $this->token->getEncoded(),
        ];
    }
}
