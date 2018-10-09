<?php

declare(strict_types=1);

namespace Application\Resource;

use Domain\User\User;

final class UserResource implements ResourceInterface
{
    /**
     * @var User
     */
    private $user;

    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    public function getType(): string
    {
        return 'users';
    }

    public function getId(): string
    {
        return (string) $this->user->getUserId()->getId();
    }

    public function getAttributes(array $fields = []): array
    {
        $userData = $this->user->getUserData();
        $attributes = [
            'username' => $userData->getUsername(),
        ];

        return $attributes;
    }
}
