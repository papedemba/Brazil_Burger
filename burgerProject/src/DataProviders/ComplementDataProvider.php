<?php

namespace App\DataProviders;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Complement;
use App\Entity\Taille;
use App\Repository\PortionFriteRepository;
use App\Repository\TailleRepository;

final class ComplementDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $taillerepo;
    private $portionRepo;

    public function __construct(TailleRepository $taillerepo,PortionFriteRepository $portionRepo)
    {
     $this->taillerepo=$taillerepo;
     $this->portionRepo=$portionRepo;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complement::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, 
    string $operationName = null, 
    array $context = [],
    
    ): ?iterable
     {
    //     $complements=[];
    
    //     $complements["tailes"]=$this->taillerepo->findAll();
    //     $complements["protionsFrite"]=$this->portionRepo->findAll();
        // Retrieve the blog post collection from somewhere
        // yield new BlogPost(1);
        // yield new BlogPost(2);

        return [
            ["tailles"=>$this->taillerepo->findAll()],
            ["portionsFrite"=>$this->portionRepo->findAll()]
        ];
    }

}

