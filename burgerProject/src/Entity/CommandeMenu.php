<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeMenuRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: CommandeMenuRepository::class)]
#[ApiResource]
class CommandeMenu
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
    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'commandeMenus')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeMenus')]
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

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

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
        if (!($this->getMenu()) ) {
            $context->buildViolation('Au moins un Menu ')
                    ->addViolation();
        }
    }
}
