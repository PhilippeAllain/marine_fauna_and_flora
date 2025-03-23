<?php

namespace App\Entity;

use App\Repository\FaunaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FaunaRepository::class)]
#[UniqueEntity('name')]
#[UniqueEntity('dci')]
#[UniqueEntity('slug')]
class Fauna
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\length(min: 5)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\length(min: 5)]
    #[Assert\Regex(pattern: '/^[a-z-]+(?:-[a-z]+)*$/', message: 'La DCI ne doit contenir que des lettres minuscules, et des tirets.')]
    private ?string $dci = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\length(min: 5)]
    #[Assert\Regex(pattern: '/^[a-zA-Z0-9-]+(?:-[a-zA-Z0-9]+)*$/', message: 'Le contenu ne doit contenir que des lettres, des chiffres et des tirets.')]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    #[Assert\length(min: 5)]
    #[Assert\Regex(pattern: '/^[a-z0-9-]+(?:-[a-z0-9]+)*$/', message: 'Le slug ne doit contenir que des lettres minuscules, des chiffres et des tirets.')]
    private ?string $slug = null;

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

    public function getDci(): ?string
    {
        return $this->dci;
    }

    public function setDci(?string $dci): static
    {
        $this->dci = $dci;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
