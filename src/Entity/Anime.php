<?php

namespace App\Entity;

use App\Repository\AnimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnimeRepository::class)]
#[UniqueEntity('name')]
class Anime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Length(min: 1, max: 50 )]
    #[Assert\NotBlank()]
    private ?string $name;

    #[ORM\Column( type: 'integer')]
    #[Assert\Positive()]
    private ?int $episodes;

    #[ORM\Column(type:'integer' , nullable: true)]
    #[Assert\PositiveOrZero()]
    private ?int $period = null;

    #[ORM\Column( type: 'string', length: 250, nullable: true )]
    #[Assert\Length(min: 0 , max: 250 )]
    private ?string $description;

    #[ORM\ManyToMany(targetEntity: Genre::class, mappedBy: 'animes')]
    private Collection $category;

    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEpisodes(): ?int
    {
        return $this->episodes;
    }

    public function setEpisodes(int $episodes): static
    {
        $this->episodes = $episodes;

        return $this;
    }
    public function getPeriod(): ?int
    {
        return $this->period;
    }

    public function setPeriod(?int $period): static
    {
        $this->period = $period;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
}

    /**
     * @return Collection<int, Genre>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Genre $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
            $category->addAnime($this);
        }

        return $this;
    }

    public function removeCategory(Genre $category): static
    {
        if ($this->category->removeElement($category)) {
            $category->removeAnime($this);
        }

        return $this;
    }
}