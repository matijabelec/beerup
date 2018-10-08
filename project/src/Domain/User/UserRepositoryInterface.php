<?php

namespace Domain\User;

interface UserRepositoryInterface
{
    public function fetchByUsername(string $username): User;
}
