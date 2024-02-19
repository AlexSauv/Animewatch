<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('name')]
#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\Length(min: 1, max: 20 )]
    #[Assert\NotBlank()]
    private ?string $name;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;
    #[Assert\NotBlank()]

    #[ORM\ManyToMany(targetEntity: Anime::class, inversedBy: 'category')]
    private Collection $animes;

    public function __construct()
    {
        $this->animes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, anime>
     */
    public function getAnimes(): Collection
    {
        return $this->animes;
    }

    public function addAnime(anime $anime): static
    {
        if (!$this->animes->contains($anime)) {
            $this->animes->add($anime);
        }

        return $this;
    }

    public function removeAnime(anime $anime): static
    {
        $this->animes->removeElement($anime);

        return $this;
    }
}
