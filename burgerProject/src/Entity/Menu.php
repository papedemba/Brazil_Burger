<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;

use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(collectionOperations:["get"=>[
    'normalization_context' => ['groups' => ['menu:read:simple']
]]
,"post"=>[
    'denormalization_context' => ['groups' => ['menu:read:all']],
    'normalization_context' => ['groups' => ['menu:read:simple']],
    'input_formats' => [
        'multipart' => ['multipart/form-data']]

    
]])]
class Menu extends Produit
{
    // #[Groups(['menu:read:all','menu:read:simple'])]
    // #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    // private $burgers;
    // #[Groups(['menu:read:all','menu:read:simple'])]
    #[Groups(['menu:read:all'])]
    #[ORM\ManyToMany(targetEntity: PortionFrite::class, inversedBy: 'menus',cascade:["persist","remove"])]
    private $portionFrites;

    // #[ORM\ManyToMany(targetEntity: Taille::class, inversedBy: 'menus')]
    // private $tailles;
    #[Groups(['menu:read:all'])]
    #[Assert\Valid()]
    #[Assert\NotBlank()]
    #[Assert\Count(
        min: 1,
        minMessage: 'Au moins un Burger',
       
    )]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:["persist","remove"])]
    private $menuBurgers;

    
    #[Groups(['menu:read:all'])]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTaille::class,cascade:["persist","remove"])]
    private $menuTailles;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: CommandeMenu::class)]
    private $commandeMenus;

   

    public function __construct()
    {
        // $this->burgers = new ArrayCollection();
        $this->portionFrites = new ArrayCollection();
        // $this->tailles = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
        $this->commandeMenus = new ArrayCollection();
    }

    // /**
    //  * @return Collection<int, Burger>
    //  */
    // public function getBurgers(): Collection
    // {
    //     return $this->burgers;
    // }

    // public function addBurger(Burger $burger): self
    // {
    //     if (!$this->burgers->contains($burger)) {
    //         $this->burgers[] = $burger;
    //     }

    //     return $this;
    // }

    // public function removeBurger(Burger $burger): self
    // {
    //     $this->burgers->removeElement($burger);

    //     return $this;
    // }

    /**
     * @return Collection<int, PortionFrite>
     */
    public function getPortionFrites(): Collection
    {
        return $this->portionFrites;
    }

    public function addPortionFrite(PortionFrite $portionFrite): self
    {
        if (!$this->portionFrites->contains($portionFrite)) {
            $this->portionFrites[] = $portionFrite;
        }

        return $this;
    }

    public function removePortionFrite(PortionFrite $portionFrite): self
    {
        $this->portionFrites->removeElement($portionFrite);

        return $this;
    }

    // /**
    //  * @return Collection<int, Taille>
    //  */
    // public function getTailles(): Collection
    // {
    //     return $this->tailles;
    // }

    // public function addTaille(Taille $taille): self
    // {
    //     if (!$this->tailles->contains($taille)) {
    //         $this->tailles[] = $taille;
    //     }

    //     return $this;
    // }

    // public function removeTaille(Taille $taille): self
    // {
    //     $this->tailles->removeElement($taille);

    //     return $this;
    // }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
    }

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
            $menuTaille->setMenu($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTaille $menuTaille): self
    {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getMenu() === $this) {
                $menuTaille->setMenu(null);
            }
        }

        return $this;
    }
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if (count($this->getMenuTailles())==0 && count($this->getPortionFrites())==0) {
            $context->buildViolation('Au moins un complement')
                ->addViolation();
        }
    }

    /**
     * @return Collection<int, CommandeMenu>
     */
    public function getCommandeMenus(): Collection
    {
        return $this->commandeMenus;
    }

    public function addCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if (!$this->commandeMenus->contains($commandeMenu)) {
            $this->commandeMenus[] = $commandeMenu;
            $commandeMenu->setMenu($this);
        }

        return $this;
    }

    public function removeCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if ($this->commandeMenus->removeElement($commandeMenu)) {
            // set the owning side to null (unless already changed)
            if ($commandeMenu->getMenu() === $this) {
                $commandeMenu->setMenu(null);
            }
        }

        return $this;
    }

   
}
