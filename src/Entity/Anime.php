<?php

namespace App\Entity;

use App\Repository\Anime\AnimeRepository as AnimeAnimeRepository;
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
    #[Assert\NotNull()]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Length(min: 1, max: 50 )]
    #[Assert\NotBlank()]
    private ?string $name = null;

    #[ORM\Column( type: 'integer')]
    #[Assert\Positive()]
    private ?int $episodes = null;

    #[ORM\Column(type:'integer' , nullable: true)]
    #[Assert\PositiveOrZero()]
    private ?int $period = null;

    #[ORM\Column( type: 'string', length: 250, nullable: true )]
    #[Assert\Length(min: 0 , max: 250 )]
    private ?string $description;


    #[ORM\OneToOne( inversedBy: 'anime', targetEntity: Pictures::class, cascade: ['persist', 'remove'])]
    private Pictures $pictures;

    #[ORM\ManyToOne(inversedBy: 'animes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: WatchList::class, mappedBy: 'anime')]
    private Collection $watchLists;

    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'anime', orphanRemoval: true)]
    private Collection $notes;

    private ?float $average = null;

    public function __construct()
    {
        $this->watchLists = new ArrayCollection();
        $this->notes = new ArrayCollection();
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



 
    public function __toString()
    {
        return $this->name;
    }

    public function getPictures(): ?Pictures
    {
        return $this->pictures;
    }

    public function setPictures(?Pictures $pictures): self
    {
        $this->pictures = $pictures;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, WatchList>
     */
    public function getWatchLists(): Collection
    {
        return $this->watchLists;
    }

    public function addWatchList(WatchList $watchList): static
    {
        if (!$this->watchLists->contains($watchList)) {
            $this->watchLists->add($watchList);
            $watchList->addAnime($this);
        }

        return $this;
    }

    public function removeWatchList(WatchList $watchList): static
    {
        if ($this->watchLists->removeElement($watchList)) {
            $watchList->removeAnime($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setAnime($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getAnime() === $this) {
                $note->setAnime(null);
            }
        }

        return $this;
    }
    public function getAverage()
    {
        $notes = $this->notes;

        if($notes->toArray() === []) {
            $this->average = null;
            return $this->average;
        }

        $total = 0;
        foreach ($notes as $note){
            $total += $note->getNote();
        }
        $this->average = $total / count($notes);
        return $this->average;
    }
}