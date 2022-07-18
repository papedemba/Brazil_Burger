<?php

namespace App\DataPersister;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Services\CalculPrixService;


class MenuDataPersister implements DataPersisterInterface
    {
     
    private EntityManagerInterface $entityManager;
   
    public function __construct(
        EntityManagerInterface $entityManager,CalculPrixService $menuService,
        
        )
        {
        
        $this->entityManager = $entityManager;
        $this->menuService=$menuService;
        

        
       

        }
    public function supports($data): bool
        {
        return $data instanceof Menu;
        }
        /**
        * @param Menu $data
        */
        public function persist($data)
        {
            if ($data instanceof Menu) {
                $image = stream_get_contents(fopen($data->getFile()->getRealPath(),"rb"));
                // $prix=$data->getPrix();
                // dd($image);
                // $fprix=floatval($prix) ;
                // dd($fprix);
                $data->setImg($image);
             }
        // $menuService= new CalculPrixService();
        $data=$this->menuService->PrixMenu($data);
        // $data=$this->encodeImageService->getAttributes($data['request']);
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