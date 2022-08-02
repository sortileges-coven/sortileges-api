<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SigilSpellRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SigilSpellRepository::class)]
#[ApiResource(attributes: ['security' => "is_granted('ROLE_USER')"], shortName: 'sigil-spells')]
class SigilSpell
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $target = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $short_target = null;

    #[ORM\Column(length: 1500)]
    #[Assert\NotBlank]
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getShortTarget(): ?string
    {
        return $this->short_target;
    }

    public function setShortTarget(?string $short_target): self
    {
        $this->short_target = $short_target;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
