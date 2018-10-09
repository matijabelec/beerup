<?php

namespace Infrastructure\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Infrastructure\Doctrine\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40, unique=true)
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity="Infrastructure\Doctrine\Entity\FavoriteBeer", mappedBy="user")
     */
    private $favoriteBeers;

    public function __construct()
    {
        $this->favoriteBeers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|FavoriteBeer[]
     */
    public function getFavoriteBeers(): Collection
    {
        return $this->getFavoriteBeers();
    }
}
