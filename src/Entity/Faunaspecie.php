<?php

namespace App\Entity;

use App\Repository\FaunaspecieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FaunaspecieRepository::class)]
#[UniqueEntity('name')]
class Faunaspecie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 5)]
    private ?string $name = null;

    /**
     * @var Collection<int, Fauna>
     */
    #[ORM\OneToMany(targetEntity: Fauna::class, mappedBy: 'species')]
    private Collection $faunas;

    public function __construct()
    {
        $this->faunas = new ArrayCollection();
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
     * @return Collection<int, Fauna>
     */
    public function getFaunas(): Collection
    {
        return $this->faunas;
    }

    public function addFauna(Fauna $fauna): static
    {
        if (!$this->faunas->contains($fauna)) {
            $this->faunas->add($fauna);
            $fauna->setSpecies($this);
        }

        return $this;
    }

    public function removeFauna(Fauna $fauna): static
    {
        if ($this->faunas->removeElement($fauna)) {
            // set the owning side to null (unless already changed)
            if ($fauna->getSpecies() === $this) {
                $fauna->setSpecies(null);
            }
        }

        return $this;
    }
}
