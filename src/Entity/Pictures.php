<?php

namespace App\Entity;

use App\Repository\PicturesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PicturesRepository::class)]
class Pictures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $dede = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDede(): ?string
    {
        return $this->dede;
    }

    public function setDede(string $dede): static
    {
        $this->dede = $dede;

        return $this;
    }
}
