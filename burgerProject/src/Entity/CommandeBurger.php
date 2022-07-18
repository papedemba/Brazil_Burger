<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeBurgerRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: CommandeBurgerRepository::class)]
#[ApiResource]
class CommandeBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    #[Groups(['Commande:read:simple'])]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(['Commande:read:simple'])]
    #[Assert\Positive(message:'doit etre positif ou null')]
    #[Assert\NotBlank(message:' ne doit pas etre null')]
    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[Groups(['Commande:read:simple'])]
    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'commandeBurgers')]
    private $burger;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeBurgers')]
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if (!($this->getBurger()) ) {
            $context->buildViolation('Au moins un burger ')
                ->addViolation();
        }
    }
}
