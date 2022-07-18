<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    
    #[Groups(['complement:read:all','menu:read:all','Commande:read:simple'])]  
    private $id;
    #[Groups(['complement:read:all','menu:read:all','Commande:read:simple'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\Column(type: 'float', nullable: true)]
    private $prix;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: MenuTaille::class)]
    private $menuTailles;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: BoissonTaille::class)]
    private $boissonTailles;


    // #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'tailles')]
    // private $menus;

   

    // #[ORM\ManyToMany(targetEntity: Boisson::class, mappedBy: 'tailles')]
    // private $boissons;

    public function __construct()
    {
        // $this->menus = new ArrayCollection();
        $this->complements = new ArrayCollection();
        // $this->boissons = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
        $this->boissonTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

   
    // /**
    //  * @return Collection<int, Menu>
    //  */
    // public function getMenus(): Collection
    // {
    //     return $this->menus;
    // }

    // public function addMenu(Menu $menu): self
    // {
    //     if (!$this->menus->contains($menu)) {
    //         $this->menus[] = $menu;
    //         $menu->addTaille($this);
    //     }

    //     return $this;
    // }

    // public function removeMenu(Menu $menu): self
    // {
    //     if ($this->menus->removeElement($menu)) {
    //         $menu->removeTaille($this);
    //     }

    //     return $this;
    // }

   
    

    

    // /**
    //  * @return Collection<int, Boisson>
    //  */
    // public function getBoissons(): Collection
    // {
    //     return $this->boissons;
    // }

    // public function addBoisson(Boisson $boisson): self
    // {
    //     if (!$this->boissons->contains($boisson)) {
    //         $this->boissons[] = $boisson;
    //         $boisson->addTaille($this);
    //     }

    //     return $this;
    // }

    // public function removeBoisson(Boisson $boisson): self
    // {
    //     if ($this->boissons->removeElement($boisson)) {
    //         $boisson->removeTaille($this);
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenuTailles(): Collection
    {
        return $this->menuTailles;
    }

    public function addMenuTaille(MenuTaille $menuTaille): self
    {
        if (!$this->menuTailles->contains($menuTaille)) {
            $this->menuTailles[] = $menuTaille;
            $menuTaille->setTaille($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTaille $menuTaille): self
    {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getTaille() === $this) {
                $menuTaille->setTaille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissonTailles(): Collection
    {
        return $this->boissonTailles;
    }

    public function addBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if (!$this->boissonTailles->contains($boissonTaille)) {
            $this->boissonTailles[] = $boissonTaille;
            $boissonTaille->setTaille($this);
        }

        return $this;
    }

    public function removeBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if ($this->boissonTailles->removeElement($boissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($boissonTaille->getTaille() === $this) {
                $boissonTaille->setTaille(null);
            }
        }

        return $this;
    }
}
