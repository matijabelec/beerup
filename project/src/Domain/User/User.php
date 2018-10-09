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

    /**
     * @var UserFavoriteBeers
     */
    private $userFavoriteBeers;

    public function __construct(
        UserId $userId,
        UserData $userData,
        UserFavoriteBeers $userFavoriteBeers
    ) {
        $this->userId = $userId;
        $this->userData = $userData;
        $this->userFavoriteBeers = $userFavoriteBeers;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getUserData(): UserData
    {
        return $this->userData;
    }

    public function getUserFavoriteBeers(): UserFavoriteBeers
    {
        return $this->userFavoriteBeers;
    }
}
