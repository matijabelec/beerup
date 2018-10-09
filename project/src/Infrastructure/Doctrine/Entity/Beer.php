<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Infrastructure\Doctrine\Repository\BeerRepository")
 */
class Beer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $abv;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $ibu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageUrl;

    /**
     * @ORM\OneToMany(targetEntity="Infrastructure\Doctrine\Entity\FavoriteBeer", mappedBy="beer")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAbv(): ?float
    {
        return $this->abv;
    }

    public function setAbv(float $abv): self
    {
        $this->abv = $abv;

        return $this;
    }

    public function getIbu(): ?float
    {
        return $this->ibu;
    }

    public function setIbu(?float $ibu): self
    {
        $this->ibu = $ibu;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

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
