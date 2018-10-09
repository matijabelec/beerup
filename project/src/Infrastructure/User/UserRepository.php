<?php

declare(strict_types=1);

namespace Infrastructure\User;

use Doctrine\ORM\EntityManagerInterface;
use Domain\User\Browse\BrowseUserRepositoryInterface;
use Domain\User\User;
use Domain\User\UserData;
use Domain\User\UserId;
use Domain\User\UserNotFoundException;
use Domain\User\UserRepositoryInterface;
use Infrastructure\Doctrine\Repository\UserRepository as DoctrineUserRepository;

class UserRepository implements
    UserRepositoryInterface,
    BrowseUserRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var DoctrineUserRepository
     */
    private $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        DoctrineUserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public function fetchByUsername(
        string $username
    ): User {
        $userEntity = $this->userRepository->findOneBy([
            'username' => $username,
        ]);

        if (null === $userEntity) {
            throw new UserNotFoundException(
                sprintf('User with username %s not found', $username)
            );
        }

        $user = new User(
            new UserId($userEntity->getId()),
            new UserData(
                $userEntity->getUsername()
            )
        );

        return $user;
    }

    /**
     * @return User[]
     */
    public function browse(): array
    {
        $userEntities = $this->userRepository->findAll();

        $users = [];
        foreach ($userEntities as $userEntity) {
            $users[] = new User(
                new UserId($userEntity->getId()),
                new UserData(
                    $userEntity->getUsername()
                )
            );
        }

        return $users;
    }
}
