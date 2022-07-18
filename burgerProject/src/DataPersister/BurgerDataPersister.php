<?php
namespace App\DataPersister;
use App\Entity\Burger;
// use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

 class BurgerDataPersister implements DataPersisterInterface     {
          private EntityManagerInterface $entityManager;
   
    public function __construct(
        EntityManagerInterface $entityManager,
        
        
        )        {
        
        $this->entityManager = $entityManager;
        // $this->menuService=$menuService;
        //  $this->encodeImageService=$encodeImageService;
        // $this->request=$request;

        
       

        }
    public function supports($data): bool
        {
        return $data instanceof Burger;
        }
        /**
        * @param Burger $data
        */
        public function persist($data)
        {
         if ($data instanceof Burger) {
            $image = stream_get_contents(fopen($data->getFile()->getRealPath(),"rb"));
            // $prix=$data->getPrix();
            // dd($image);
            // $fprix=floatval($prix) ;
            // dd($fprix);
            $data->setImg($image);
         }
         $data->setIsEtat(true);
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();  
        }
        public function remove($data)
        {
        $data->setIsEtat(false);
        // $this->entityManager->remove($data);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        }
        }