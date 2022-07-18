<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
#[ApiResource]
class MenuBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[Groups(['menu:read:all'])]
    #[Assert\Positive(message:'doit etre positif ou null')]
    #[Assert\NotBlank(message:' ne doit pas etre null')]
    #[ORM\Column(type: 'integer')]
    private $nbrelt;

    #[Groups(['menu:read:all'])]
    #[Assert\NotBlank(message:"boum null")]
    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    private $burger;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBurgers')]
    private $menu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrelt(): ?int
    {
        return $this->nbrelt;
    }

    public function setNbrelt(int $nbrelt): self
    {
        $this->nbrelt = $nbrelt;

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

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}
