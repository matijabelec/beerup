<?php

declare(strict_types=1);

namespace Infrastructure\Beer;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Domain\Beer\BeerId;
use Domain\Beer\BeerNotFoundException;
use Domain\Beer\FavoriteBeer\BeerAlreadyAddedToFavoriteException;
use Domain\Beer\FavoriteBeer\FavoriteBeerNotFoundException;
use Domain\Beer\FavoriteBeer\FavoriteBeerRepositoryInterface;
use Domain\Beer\FavoriteBeer\UserId;
use Domain\Beer\FavoriteBeer\UserNotFoundException;
use Infrastructure\Doctrine\Entity\Beer as BeerEntity;
use Infrastructure\Doctrine\Entity\User as UserEntity;
use Infrastructure\Doctrine\Entity\FavoriteBeer as FavoriteBeerEntity;
use Infrastructure\Doctrine\Repository\BeerRepository as DoctrineBeerRepository;
use Infrastructure\Doctrine\Repository\FavoriteBeerRepository as DoctrineFavoriteBeerRepository;
use Infrastructure\Doctrine\Repository\UserRepository as DoctrineUserRepository;

class FavoriteBeerRepository implements FavoriteBeerRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var DoctrineBeerRepository
     */
    private $beerRepository;

    /**
     * @var DoctrineFavoriteBeerRepository
     */
    private $favoriteBeerRepository;

    /**
     * @var DoctrineUserRepository
     */
    private $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        DoctrineBeerRepository $beerRepository,
        DoctrineFavoriteBeerRepository $favoriteBeerRepository,
        DoctrineUserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->beerRepository = $beerRepository;
        $this->favoriteBeerRepository = $favoriteBeerRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws BeerAlreadyAddedToFavoriteException
     * @throws BeerNotFoundException
     * @throws UserNotFoundException
     */
    public function addFavoriteBeer(
        UserId $userId,
        BeerId $beerId
    ): void {
        $beerEntity = $this->beerRepository->find($beerId->getId());

        if (null === $beerEntity) {
            throw new BeerNotFoundException();
        }

        $userEntity = $this->userRepository->find($userId->getId());

        if (null === $userEntity) {
            throw new UserNotFoundException();
        }

        $favoriteBeer = $this->favoriteBeerRepository->findOneBy([
            'user' => $userEntity,
            'beer' => $beerEntity,
        ]);

        if (null !== $favoriteBeer) {
            throw new BeerAlreadyAddedToFavoriteException();
        }

        $favoriteBeer = new FavoriteBeerEntity();
        $favoriteBeer->setBeer($beerEntity)
            ->setUser($userEntity)
            ->setTimeAdded(new DateTime());

        $this->entityManager->persist($favoriteBeer);
        $this->entityManager->flush();
    }

    /**
     * @throws FavoriteBeerNotFoundException
     */
    public function removeFavoriteBeer(
        UserId $userId,
        BeerId $beerId
    ): void {
        $userEntity = $this->entityManager->getReference(UserEntity::class, $userId->getId());
        $beerEntity = $this->entityManager->getReference(BeerEntity::class, $beerId->getId());
        $favoriteBeerEntity = $this->favoriteBeerRepository->findOneBy([
            'user' => $userEntity,
            'beer' => $beerEntity,
        ]);

        if (null === $favoriteBeerEntity) {
            throw new FavoriteBeerNotFoundException(
                sprintf('Favorite beer with id %d not found', $beerId->getId())
            );
        }

        $this->entityManager->remove($favoriteBeerEntity);
        $this->entityManager->flush();
    }
}
