<?php

namespace App\DataPersister;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Services\PrixCommandeService;

class CommandeDataPersister implements DataPersisterInterface
    {
     
    private EntityManagerInterface $entityManager;
   
    public function __construct(
        EntityManagerInterface $entityManager,
        PrixCommandeService $prixCommandeService
        
        )
        {
        
        $this->entityManager = $entityManager;
         $this->prixCommandeService=$prixCommandeService;

        }

        
    public function supports($data): bool
        {
        return $data instanceof Commande;
        }
        /**
        * @param Commande $data
        */
        public function persist($data)
        {
        
        // $menuService= new CalculPrixService();
        
        // $data=$this->encodeImageService->getAttributes($data['request']);
        $data=$this->prixCommandeService->CalculPrixCommande($data);
        $data->setNCommande($this->prixCommandeService->generedNumber());
         $data->setIsEtat(true);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        
        }
        public function remove($data)
        {
        $data->setIsEtat(false);
        $this->entityManager->remove($data);
        $this->entityManager->flush();
        }
        }