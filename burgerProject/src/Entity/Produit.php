<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["produit" => "Produit", "menu" => "Menu","burger"=>"Burger","portionfrite"=>"PortionFrite","boisson"=>"Boisson"])]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue] 

    #[Groups(["burger:read:simple","burger:read:all",'complement:read:all','menu:read:all','Commande:read:simple','Commande:read:simple','burger:write'])]

    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["burger:read:simple","burger:read:all",'complement:read:all','menu:read:all','portion:read:all','burger:write:simple','Commande:read:simple','burger:write'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[Groups(["burger:read:simple",'complement:read:all','portion:read:all','burger:write:simple','burger:write'])]
    #[ORM\Column(type: 'float',nullable:true)]
    private $prix;

    #[Groups(["burger:read:all"])]
    

    #[ORM\Column(type: 'boolean',nullable:true)]
    private $isEtat;

    // #[ORM\OneToMany(mappedBy: 'produit', targetEntity: ProduitCommande::class,cascade:["persist"])]
    private $produitCommandes;

    #[Groups(['burger:write:simple','burger:write'])]
    #[ORM\Column(type: 'blob', nullable: true)]
    private $img;

    #[UploadableField(mapping:"media_object", fileNameProperty:"filePath")]
     
    #[Groups(["burger:write:simple",'menu:read:all'])]

    public ?File $file = null;

    public function __construct()
    {
        // $this->produitCommandes = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }

    

    public function getImg()

    {
        $img=$this->img;

        // dd($img);
        if (is_resource($img)) {
            return base64_encode(stream_get_contents($img));
        }elseif ($img) {
            return base64_encode($img);
        }
        return null;
    }

    public function setImg($img): self
    {
        $this->img = $img;

        return $this;
    }
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */ 
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

   
}
