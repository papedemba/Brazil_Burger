<?php

namespace App\Services;

use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Commande;
use App\Entity\Produit;

class PrixCommandeService {



public function CalculPrixCommande($data){
         $montTotal=0;

        if ($data instanceof Commande) {
            
          foreach ($data->getCommandeBurgers() as  $burgers) {
               $montTotal +=$burgers->getBurger()->getPrix();
          }
          foreach ($data->getCommandeMenus() as $menus) {
                $montTotal += $menus->getMenu()->getPrix();
          }
          foreach ($data->getCommandeBoissonTailles() as $tailles) {
                $montTotal += $tailles->getBoissonTaille()->getTaille()->getPrix();
          }
          $data->setMontant($montTotal);
                
        }
        return $data;
        
        }

        public function generedNumber():int{
            $x=rand(0,2);
            $y=rand(10,20);
            $z=$x+$y;
            return $z;
        }

}


    
