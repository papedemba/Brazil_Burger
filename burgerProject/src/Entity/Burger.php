<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations:["get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['burger:read:simple']],
        ],
        "post"=>[
            'denormalization_context' => ['groups' => ['burger:write:simple']],
            'normalization_context' => ['groups' => ['burger:write']],
        'input_formats' => [
            'multipart' => ['multipart/form-data'],
        ],

        ]],
    itemOperations:["put","get"=>[
        'method' => 'get',
        'normalization_context' => ['groups' => ['burger:read:all']],
        ],]
)]
class Burger extends Produit
{

    
    //  #[UploadableField(mapping:"media_object", fileNameProperty:"filePath")]
     
    // #[Groups(["burger:write:simple"])]

    // public ?File $file = null;

    // #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'burgers')]
    // #[ORM\JoinColumn(nullable: true)]
    // private $gestionnaire;

    // #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'burgers')]
    // private $menus;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'burgers')]
    #[Groups(["burger:read:all"])]
    private $gestionnaire;

    // #[ORM\ManyToOne(targetEntity: MenuBurger::class, inversedBy: 'burgers')]
    private $menuBurger;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurger::class)]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: CommandeBurger::class)]
    private $commandeBurgers;

    public function __construct()
    {
        // $this->menus = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->commandeBurgers = new ArrayCollection();
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
    //         $menu->addBurger($this);
    //     }

    //     return $this;
    // }

    // public function removeMenu(Menu $menu): self
    // {
    //     if ($this->menus->removeElement($menu)) {
    //         $menu->removeBurger($this);
    //     }

    //     return $this;
    // }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    // public function getMenuBurger(): ?MenuBurger
    // {
    //     return $this->menuBurger;
    // }

    // public function setMenuBurger(?MenuBurger $menuBurger): self
    // {
    //     $this->menuBurger = $menuBurger;

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
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    // public function removeMenuBurger(MenuBurger $menuBurger): self
    // {
    //     if ($this->menuBurgers->removeElement($menuBurger)) {
    //         // set the owning side to null (unless already changed)
    //         if ($menuBurger->getBurger() === $this) {
    //             $menuBurger->setBurger(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * Get the value of file
     */ 
    // public function getFile()
    // {
    //     return $this->file;
    // }

    // /**
    //  * Set the value of file
    //  *
    //  * @return  self
    //  */ 
    // public function setFile($file)
    // {
    //     $this->file = $file;

    //     return $this;
    // }

    /**
     * @return Collection<int, CommandeBurger>
     */
    public function getCommandeBurgers(): Collection
    {
        return $this->commandeBurgers;
    }

    public function addCommandeBurger(CommandeBurger $commandeBurger): self
    {
        if (!$this->commandeBurgers->contains($commandeBurger)) {
            $this->commandeBurgers[] = $commandeBurger;
            $commandeBurger->setBurger($this);
        }

        return $this;
    }

    public function removeCommandeBurger(CommandeBurger $commandeBurger): self
    {
        if ($this->commandeBurgers->removeElement($commandeBurger)) {
            // set the owning side to null (unless already changed)
            if ($commandeBurger->getBurger() === $this) {
                $commandeBurger->setBurger(null);
            }
        }

        return $this;
    }
}
