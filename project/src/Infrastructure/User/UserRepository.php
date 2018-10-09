<?php

declare(strict_types=1);

namespace Infrastructure\User;

use Doctrine\ORM\EntityManagerInterface;
use Domain\User\Browse\BrowseUserRepositoryInterface;
use Domain\User\User;
use Domain\User\UserData;
use Domain\User\UserFavoriteBeers;
use Domain\User\UserId;
use Domain\User\UserNotFoundException;
use Domain\User\UserRepositoryInterface;
use Infrastructure\Doctrine\Repository\FavoriteBeerRepository;
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

    /**
     * @var FavoriteBeerRepository
     */
    private $favoriteBeerRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        DoctrineUserRepository $userRepository,
        FavoriteBeerRepository $favoriteBeerRepository
    ) {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->favoriteBeerRepository = $favoriteBeerRepository;
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
            ),
            new UserFavoriteBeers([])
        );

        return $user;
    }

    /**
     * @return User[]
     */
    public function browse(): array
    {
        $userEntities = $this->userRepository->findAll();
        $results = $this->favoriteBeerRepository->findAllFavoriteBeerNamesPerUsers();

        $map = [];
        foreach ($results as $result) {
            $map[$result['user_id']][] = $result['beer_name'];
        }

        $users = [];
        foreach ($userEntities as $userEntity) {
            $userId = $userEntity->getId();
            $users[] = new User(
                new UserId($userId),
                new UserData(
                    $userEntity->getUsername()
                ),
                new UserFavoriteBeers($map[$userId] ?? [])
            );
        }

        return $users;
    }
}
