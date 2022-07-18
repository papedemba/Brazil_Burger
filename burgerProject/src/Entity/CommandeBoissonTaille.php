<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeBoissonTailleRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeBoissonTailleRepository::class)]
#[ApiResource]
class CommandeBoissonTaille
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
    #[ORM\ManyToOne(targetEntity: BoissonTaille::class, inversedBy: 'commandeBoissonTailles',cascade:['persist'])]
    private $boissonTaille;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeBoissonTailles')]
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

    public function getBoissonTaille(): ?BoissonTaille
    {
        return $this->boissonTaille;
    }

    public function setBoissonTaille(?BoissonTaille $boissonTaille): self
    {
        $this->boissonTaille = $boissonTaille;

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
    
}
