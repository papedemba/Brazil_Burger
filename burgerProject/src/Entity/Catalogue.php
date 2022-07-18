<?php

namespace App\Entity;

use App\Repository\CatalogueRepository;
use ApiPlatform\Core\Annotation\ApiResource;


#[ApiResource]
class Catalogue
{
    
    private $id;

   
    private array $menus = [];

   
    private array $burgers = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenus(): ?array
    {
        return $this->menus;
    }

    public function setMenus(?array $menus): self
    {
        $this->menus = $menus;

        return $this;
    }

    public function getBurgers(): ?array
    {
        return $this->burgers;
    }

    public function setBurgers(array $burgers): self
    {
        $this->burgers = $burgers;

        return $this;
    }
}
