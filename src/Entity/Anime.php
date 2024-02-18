<?php

namespace App\Entity;

use App\Repository\AnimeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimeRepository::class)]
class Anime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'This value should not be blank')]
    #[Assert\Length(
        min: 1,
        max: 100,
    )]
    private ?string $name =  null;

    #[ORM\Column(length: 25, nullable: true)]
    #[Assert\Length(
        min: 0,
        max: 25,
    )]
    private ?string $genre = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\Positive]
    private ?int $numberOfEpisodes = null;

    #[ORM\Column(length: 400, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull()]
    #[Assert\DateTime]
    private ?\DateTimeInterface $year = null;

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

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getNumberOfEpisodes(): ?int
    {
        return $this->numberOfEpisodes;
    }

    public function setNumberOfEpisodes(int $numberOfEpisodes): static
    {
        $this->numberOfEpisodes = $numberOfEpisodes;

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

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(\DateTimeInterface $year): static
    {
        $this->year = $year;

        return $this;
    }
}
