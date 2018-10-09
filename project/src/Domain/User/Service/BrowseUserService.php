<?php

declare(strict_types=1);

namespace Domain\User\Service;

use Domain\User\Browse\BrowseUserRepositoryInterface;
use Domain\User\User;

final class BrowseUserService
{
    /**
     * @var BrowseUserRepositoryInterface
     */
    private $browseUserRepository;

    public function __construct(
        BrowseUserRepositoryInterface $browseUserRepository
    ) {
        $this->browseUserRepository = $browseUserRepository;
    }

    /**
     * @return User[]
     */
    public function browse(): array
    {
        return $this->browseUserRepository->browse();
    }
}
