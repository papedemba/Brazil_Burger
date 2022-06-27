<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PortionFriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource]
class PortionFrite extends Produit
{
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'portionFrites')]
    private $menus;

    #[ORM\OneToMany(mappedBy: 'portionFrite', targetEntity: Complements::class)]
    private $complements;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->complements = new ArrayCollection();
    }

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
            $menu->addPortionFrite($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removePortionFrite($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Complements>
     */
    public function getComplements(): Collection
    {
        return $this->complements;
    }

    public function addComplement(Complements $complement): self
    {
        if (!$this->complements->contains($complement)) {
            $this->complements[] = $complement;
            $complement->setPortionFrite($this);
        }

        return $this;
    }

    public function removeComplement(Complements $complement): self
    {
        if ($this->complements->removeElement($complement)) {
            // set the owning side to null (unless already changed)
            if ($complement->getPortionFrite() === $this) {
                $complement->setPortionFrite(null);
            }
        }

        return $this;
    }
}
