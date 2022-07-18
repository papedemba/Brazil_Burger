<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonTailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonTailleRepository::class)]
#[ApiResource]
class BoissonTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[Groups(['Commande:read:simple'])]
    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[Groups(['Commande:read:simple'])]
    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'boissonTailles')]
    private $boisson;

    #[Groups(['Commande:read:simple'])]
    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'boissonTailles')]
    private $taille;

    #[ORM\OneToMany(mappedBy: 'boissonTaille', targetEntity: CommandeBoissonTaille::class)]
    private $commandeBoissonTailles;

    public function __construct()
    {
        $this->commandeBoissonTailles = new ArrayCollection();
    }

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

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * @return Collection<int, CommandeBoissonTaille>
     */
    public function getCommandeBoissonTailles(): Collection
    {
        return $this->commandeBoissonTailles;
    }

    public function addCommandeBoissonTaille(CommandeBoissonTaille $commandeBoissonTaille): self
    {
        if (!$this->commandeBoissonTailles->contains($commandeBoissonTaille)) {
            $this->commandeBoissonTailles[] = $commandeBoissonTaille;
            $commandeBoissonTaille->setBoissonTaille($this);
        }

        return $this;
    }

    public function removeCommandeBoissonTaille(CommandeBoissonTaille $commandeBoissonTaille): self
    {
        if ($this->commandeBoissonTailles->removeElement($commandeBoissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($commandeBoissonTaille->getBoissonTaille() === $this) {
                $commandeBoissonTaille->setBoissonTaille(null);
            }
        }

        return $this;
    }
}
