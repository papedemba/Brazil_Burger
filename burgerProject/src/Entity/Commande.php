<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(collectionOperations:[
    "get",
    "post"=>[
        'denormalization_context' => ['groups' => ['Commande:read:simple']
        
    ]
]
],
itemOperations:[
    "get",
    "put"
])]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(['Commande:read:simple'])]

    #[ORM\Column(type: 'integer')]
    private $id;
    // #[Groups(['Commande:read:simple','Commande:read'])]
    // #[NotBlank()]
    #[ORM\Column(type: 'integer')]
    private $nCommande;

    #[Groups(['Commande:read:simple','Commande:read'])]
    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'boolean',nullable:true)]
    private $isEtat;

    #[Groups(['Commande:read:simple','Commande:read'])]
    #[ORM\Column(type: 'float')]
    private $montant;
    
    // #[Groups(['Commande:read:simple'])]
    
    // #[ORM\OneToMany(mappedBy: 'commande', targetEntity: ProduitCommande::class,cascade:["persist"])]
    // private $produitCommandes;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    private $client;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    #[Groups(['Commande:read:simple'])]
    #[Assert\Valid()]
    #[Assert\NotBlank()]
    #[Assert\Count(
        min: 1,
        minMessage: 'Au moins un Burger',
       
    )]
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeBurger::class,cascade:['persist'])]
    private $commandeBurgers;

    #[Groups(['Commande:read:simple'])]
    #[Assert\Valid()]
    #[Assert\NotBlank()]
    #[Assert\Count(
        min: 1,
        minMessage: 'Au moins un menu',
       
    )]
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeMenu::class,cascade:['persist'])]
    private $commandeMenus;

    #[Groups(['Commande:read:simple'])]
    #[Assert\Valid()]
    #[Assert\NotBlank()]
    #[Assert\Count(
        min: 1,
        minMessage: 'Au moins un menu',
       
    )]
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeBoissonTaille::class,cascade:['persist'])]
    private $commandeBoissonTailles;

    #[Groups(['Commande:read:simple'])]
    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'Commandes',cascade:["persist"])]
    private $zone;

    #[Groups(['Commande:read:simple'])]
    #[ORM\ManyToOne(targetEntity: Quartier::class, inversedBy: 'Commandes',cascade:["persist"])]
    private $quartier;


    public function __construct()
    {
        $this->commandeBurgers = new ArrayCollection();
        $this->commandeMenus = new ArrayCollection();
        $this->commandeBoissonTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNCommande(): ?int
    {
        return $this->nCommande;
    }

    public function setNCommande(int $nCommande): self
    {
        $this->nCommande = $nCommande;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    // /**
    //  * @return Collection<int, ProduitCommande>
    //  */
    // public function getProduitCommandes(): Collection
    // {
    //     return $this->produitCommandes;
    // }

    // public function addProduitCommande(ProduitCommande $produitCommande): self
    // {
    //     if (!$this->produitCommandes->contains($produitCommande)) {
    //         $this->produitCommandes[] = $produitCommande;
    //         $produitCommande->setCommande($this);
    //     }

    //     return $this;
    // }

    // public function removeProduitCommande(ProduitCommande $produitCommande): self
    // {
    //     if ($this->produitCommandes->removeElement($produitCommande)) {
    //         // set the owning side to null (unless already changed)
    //         if ($produitCommande->getCommande() === $this) {
    //             $produitCommande->setCommande(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    // /**
    //  * @return Collection<int, Burger>
    //  */
    // public function getBurgers(): Collection
    // {
    //     return $this->burgers;
    // }

    // public function addBurger(Burger $burger): self
    // {
    //     if (!$this->burgers->contains($burger)) {
    //         $this->burgers[] = $burger;
    //     }

    //     return $this;
    // }

    // public function removeBurger(Burger $burger): self
    // {
    //     $this->burgers->removeElement($burger);

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Menu>
    //  */
    // public function getMenus(): Collection
    // {
    //     return $this->menus;
    // }

    // public function addMenu(Menu $menu): self
    // {
    //     if (!$this->menus->contains($menu)) {
    //         $this->menus[] = $menu;
    //     }

    //     return $this;
    // }

    // public function removeMenu(Menu $menu): self
    // {
    //     $this->menus->removeElement($menu);

    //     return $this;
    // }

    /**
     * @return Collection<int, CommandeBurger>
     */
    public function getCommandeBurgers(): Collection
    {
        return $this->commandeBurgers;
    }

    public function addCommandeBurger(CommandeBurger $commandeBurger): self
    {
        if (!$this->commandeBurgers->contains($commandeBurger)) {
            $this->commandeBurgers[] = $commandeBurger;
            $commandeBurger->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeBurger(CommandeBurger $commandeBurger): self
    {
        if ($this->commandeBurgers->removeElement($commandeBurger)) {
            // set the owning side to null (unless already changed)
            if ($commandeBurger->getCommande() === $this) {
                $commandeBurger->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeMenu>
     */
    public function getCommandeMenus(): Collection
    {
        return $this->commandeMenus;
    }

    public function addCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if (!$this->commandeMenus->contains($commandeMenu)) {
            $this->commandeMenus[] = $commandeMenu;
            $commandeMenu->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if ($this->commandeMenus->removeElement($commandeMenu)) {
            // set the owning side to null (unless already changed)
            if ($commandeMenu->getCommande() === $this) {
                $commandeMenu->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeBoissonTaille>
     */
    public function getCommandeBoissonTailles(): Collection
    {
        return $this->commandeBoissonTailles;
    }

    public function addCommandeBoissonTaille(CommandeBoissonTaille $commandeBoissonTaille): self
    {
        if (!$this->commandeBoissonTailles->contains($commandeBoissonTaille)) {
            $this->commandeBoissonTailles[] = $commandeBoissonTaille;
            $commandeBoissonTaille->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeBoissonTaille(CommandeBoissonTaille $commandeBoissonTaille): self
    {
        if ($this->commandeBoissonTailles->removeElement($commandeBoissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($commandeBoissonTaille->getCommande() === $this) {
                $commandeBoissonTaille->setCommande(null);
            }
        }

        return $this;
    }
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if (count($this->getCommandeMenus())==0 or count($this->getCommandeBurgers())==0) {
            $context->buildViolation('Au moins un burger ou Menu')
                ->addViolation();
        }
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getQuartier(): ?Quartier
    {
        return $this->quartier;
    }

    public function setQuartier(?Quartier $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }
}
