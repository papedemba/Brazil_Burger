<?php

namespace App\DataProviders;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Catalogue;
use App\Repository\BurgerRepository;
use App\Repository\MenuRepository;


final class CatalogueDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $burgersrepo;
    private $menusRepo;

    public function __construct(BurgerRepository $burgersrepo,MenuRepository $menusRepo)
    {
     $this->burgersrepo=$burgersrepo;
     $this->menusRepo=$menusRepo;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalogue::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, 
    string $operationName = null, 
    array $context = [],
    
    ): array
    {
        // $catalogues=[];
    
        // $catalogues["burgers"]=$this->burgersrepo->findOneBy(["isEtat"=>1]);
        // $catalogues["menus"]=$this->menusRepo->findOneBy(["isEtat"=>1]);
        // Retrieve the blog post collection from somewhere
        // yield new BlogPost(1);
        // yield new BlogPost(2);

        return  [
                   ["burgers"=>$this->burgersrepo->findOneBy(["isEtat"=>1])],
                   ["menus"=>$this->menusRepo->findOneBy(["isEtat"=>1])]
                ];
    }

}

