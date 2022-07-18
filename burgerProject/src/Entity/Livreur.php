<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
#[ApiResource(collectionOperations:[
    "get"=>[
        'normalization_context' => ['groups' => ['livreur:read:all']]
    ],
    "post"
],itemOperations:["get",
"put"])]
class Livreur extends User
{
    
    #[Groups(["livreur:read:all"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $matricule;
    #[Groups(["livreur:read:all"])]

    #[ORM\Column(type: 'integer')]
    private $telephone;
    #[Groups(["livreur:read:all"])]

    #[ORM\Column(type: 'string', length: 255)]
    private $etat;

    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    private $Livraisons;

    public function __construct()
    {
        parent::__construct();
        $this->Livraisons = new ArrayCollection();
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->Livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->Livraisons->contains($livraison)) {
            $this->Livraisons[] = $livraison;
            $livraison->setLivreur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->Livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreur() === $this) {
                $livraison->setLivreur(null);
            }
        }

        return $this;
    }
}
