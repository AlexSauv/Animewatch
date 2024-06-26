<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('name')]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\Length(min: 1, max: 20 )]
    #[Assert\NotBlank()]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\OneToMany(targetEntity: Anime::class, mappedBy: 'category', fetch:"EAGER")]
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
     * @return Collection<int, Anime>
     */
    public function getAnimes(): Collection
    {
        return $this->animes;
    }

    public function addAnime(Anime $anime): static
    {
        if (!$this->animes->contains($anime)) {
            $this->animes->add($anime);
            $anime->setCategory($this);
        }

        return $this;
    }

    public function removeAnime(Anime $anime): static
    {
        if ($this->animes->removeElement($anime)) {
            // set the owning side to null (unless already changed)
            if ($anime->getCategory() === $this) {
                $anime->setCategory(null);
            }
        }

        return $this;
    }

    private $slug;

    #[ORM\Column(length: 255)]
    private ?string $image = null;



    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

}