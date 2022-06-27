<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations:["get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['burger:read:simple']],
        ],"post"],
    itemOperations:["put","get"=>[
        'method' => 'get',
        'normalization_context' => ['groups' => ['burger:read:all']],
        ],]
)]
class Burger extends Produit
{

    // #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'burgers')]
    // #[ORM\JoinColumn(nullable: true)]
    // private $gestionnaire;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'burgers')]
    private $menus;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'burgers')]
    #[Groups(["burger:read:all"])]
    private $gestionnaire;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }

    // public function getGestionnaire(): ?Gestionnaire
    // {
    //     return $this->gestionnaire;
    // }

    // public function setGestionnaire(?Gestionnaire $gestionnaire): self
    // {
    //     $this->gestionnaire = $gestionnaire;

    //     return $this;
    // }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addBurger($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeBurger($this);
        }

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }
}
