<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\MovieRepository;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ORM\Table(name: "movies")]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255, options: ["collation" => "NOCASE"])]
    private string $title;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "integer")]
    private int $releaseYear;

    #[ORM\Column(type: "string", length: 255, nullable: true, options: ["collation" => "NOCASE"])]
    private ?string $country;

    #[ORM\Column(type: "boolean", nullable: true)]
    private ?bool $isSeries = false;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $posterPath = null;

    #[ORM\Column(type: "boolean", nullable: true)]
    private bool $isAdult = false;

    #[ORM\OneToMany(mappedBy: "movie", targetEntity: "App\Entity\Review", cascade: ["remove"])]
    private Collection $reviews;

    #[ORM\ManyToMany(targetEntity: "App\Entity\Category", inversedBy: "movies")]
    #[ORM\JoinTable(name: "movie_category")]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: "App\Entity\Service", inversedBy: "movies")]
    #[ORM\JoinTable(name: "movie_service")]
    private Collection $services;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
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

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): self
    {
        $this->releaseYear = $releaseYear;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function isSeries(): ?bool
    {
        return $this->isSeries;
    }

    public function setIsSeries(?bool $isSeries): self
    {
        $this->isSeries = $isSeries;
        return $this;
    }

    public function getPosterPath(): ?string
    {
        return $this->posterPath;
    }

    public function setPosterPath(?string $posterPath): self
    {
        $this->posterPath = $posterPath;
        return $this;
    }

    public function isAdult(): bool
    {
        return $this->isAdult;
    }

    public function setIsAdult(bool $isAdult): self
    {
        $this->isAdult = $isAdult;
        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }
        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);
        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
        }
        return $this;
    }

    public function removeService(Service $service): self
    {
        $this->services->removeElement($service);
        return $this;
    }
}
