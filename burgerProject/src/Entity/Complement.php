<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;


// use ApiPlatform\Core\Annotation\ApiResource;



#[ApiResource(collectionOperations:[
    "get"=>[
        'normalization_context' => ['groups' => ['complement:read:all']
]]])]

class Complement
{
    
   private $id;

    
    private array $taille;

  
    private array $portionFrites;
    

    

    


    /**
     * Get the value of portionFrites
     */ 
    public function getPortionFrites()
    {
        return $this->portionFrites;
    }

    /**
     * Set the value of portionFrites
     *
     * @return  self
     */ 
    public function setPortionFrites($portionFrites)
    {
        $this->portionFrites = $portionFrites;

        return $this;
    }

    /**
     * Get the value of taille
     */ 
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * Set the value of taille
     *
     * @return  self
     */ 
    public function setTaille($taille)
    {
        $this->taille = $taille;

        return $this;
    }
}
