<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PortionFriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource(collectionOperations:[
    "get",
    "post"=>[
        'denormalization_context' => ['groups' => ['portion:read:all']]
]]
)]
class PortionFrite extends Produit
{   
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'portionFrites')]
    private $menus;

    

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

    
    
    

    

        
   

    
}
