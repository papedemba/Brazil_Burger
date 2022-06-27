<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource(
    collectionOperations:["get","post"],
    itemOperations:["get","put"]
)]
class Gestionnaire extends User
{
   
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Burger::class)]
    private $burgers;

    // #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Burger::class, orphanRemoval: true)]
    // private $burgers;

    public function __construct()

    {
        $this->setRoles(['ROLE_GESTIONNAIRE']);
        // $this->burgers = new ArrayCollection();
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
            $burger->setGestionnaire($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            // set the owning side to null (unless already changed)
            if ($burger->getGestionnaire() === $this) {
                $burger->setGestionnaire(null);
            }
        }

        return $this;
    }

}
