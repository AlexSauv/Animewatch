<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\WatchListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WatchListRepository::class)]
class WatchList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(inversedBy: 'watchList', cascade: ['persist', 'remove'])]
    #[Assert\NotNull()]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Anime::class, inversedBy: 'watchLists')]
    private Collection $anime;

    public function __construct()
    {
        
        $this->createdAt = new \DateTimeImmutable();
        $this->anime = new ArrayCollection();
        
        
        
    }

    public function haveWatchlist(): void
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Anime>
     */
    public function getAnime(): Collection
    {
        return $this->anime;
    }

    public function addAnime(Anime $anime): static
    {
        if (!$this->anime->contains($anime)) {
            $this->anime->add($anime);
        }

        return $this;
    }

    public function removeAnime(Anime $anime): static
    {
        $this->anime->removeElement($anime);

        return $this;
    }
    
}
