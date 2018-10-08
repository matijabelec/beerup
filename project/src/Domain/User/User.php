<?php

declare(strict_types=1);

namespace Domain\User;

final class User
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var UserData
     */
    private $userData;

    public function __construct(
        UserId $userId,
        UserData $userData
    ) {
        $this->userId = $userId;
        $this->userData = $userData;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getUserData(): UserData
    {
        return $this->userData;
    }
}
