<?php

declare(strict_types=1);

namespace Domain\User\Service;

use Domain\User\UserRepositoryInterface;

class UserDetailService
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function fetchByUsername(
        string $username
    ) {
        return $this->userRepository->fetchByUsername($username);
    }
}
