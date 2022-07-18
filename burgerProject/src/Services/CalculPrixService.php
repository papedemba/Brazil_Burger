<?php

namespace App\Services;

use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Taille;
use App\Entity\MenuBurger;
use App\Entity\MenuTaille;
use App\Entity\PortionFrite;

class CalculPrixService{

    private $total=0;
    public function PrixMenu($data)
    {
          
        if($data instanceof MenuTaille  or $data instanceof PortionFrite ){
                $data->setPrix(0);
               
        }
        elseif ($data  instanceof Menu) {
               foreach ($data->getMenuBurgers() as $burgers) {
                    $this->total += $burgers->getBurger()->getPrix()*($burgers->getNbrelt());
               }   
               foreach ($data->getPortionFrites() as $portionFrites) {
                $this->total += $portionFrites->getPrix();
               }  
               foreach ($data->getMenuTailles() as $tailles) {
                $this->total += $tailles->getTaille()->getPrix()*($tailles->getQuantite());
               }
               $data->setPrix($this->total);
        }
                      return $data;
    }

}