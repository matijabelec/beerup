<?php

namespace Domain\User\Browse;

use Domain\User\User;

interface BrowseUserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function browse(): array;
}
