<?php

namespace Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Infrastructure\Doctrine\Repository\FavoriteBeerRepository")
 */
class FavoriteBeer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timeAdded;

    /**
     * @ORM\ManyToOne(targetEntity="Infrastructure\Doctrine\Entity\Beer", inversedBy="favoriteBeers")
     */
    private $beer;

    /**
     * @ORM\ManyToOne(targetEntity="Infrastructure\Doctrine\Entity\User", inversedBy="favoriteBeers")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeAdded(): ?\DateTimeInterface
    {
        return $this->timeAdded;
    }

    public function setTimeAdded(\DateTimeInterface $timeAdded): self
    {
        $this->timeAdded = $timeAdded;

        return $this;
    }

    public function getBeer(): ?Beer
    {
        return $this->beer;
    }

    public function setBeer(?Beer $beer): self
    {
        $this->beer = $beer;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
