<?php

namespace App\Entity;

use App\Repository\FloraspecieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FloraspecieRepository::class)]
class Floraspecie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Flora>
     */
    #[ORM\OneToMany(targetEntity: Flora::class, mappedBy: 'species', cascade: ['remove'])]
    private Collection $floras;

    public function __construct()
    {
        $this->floras = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Flora>
     */
    public function getFloras(): Collection
    {
        return $this->floras;
    }

    public function addFlora(Flora $flora): static
    {
        if (!$this->floras->contains($flora)) {
            $this->floras->add($flora);
            $flora->setSpecies($this);
        }

        return $this;
    }

    public function removeFlora(Flora $flora): static
    {
        if ($this->floras->removeElement($flora)) {
            // set the owning side to null (unless already changed)
            if ($flora->getSpecies() === $this) {
                $flora->setSpecies(null);
            }
        }

        return $this;
    }
}
