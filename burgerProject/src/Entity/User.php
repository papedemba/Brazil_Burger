<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\EmailValidationController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(collectionOperations:["get"=>[
    'normalization_context' => ['groups' => ['user:read:all']]
],"post"],
itemOperations:["get","put"])]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["user" => "User", "gestionnaire" => "Gestionnaire","client"=>"Client","livreur"=>"Livreur"])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(["user:read:all"])]

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    

    #[Groups(["user:read:all",])]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
   
    protected $username;

    #[ORM\Column(type: 'json')]
    protected $roles = [];

    #[Groups(["user:read:all",])]


    #[ORM\Column(type: 'string')]
    protected $password;
    
    #[Groups(["user:read:all",])]

    

    #[ORM\Column(type: 'string', length: 255)]
    protected $prenom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $token;

    #[ORM\Column(type: 'datetime',nullable: true)]
    protected $expiredAt;

    #[ORM\Column(type: 'boolean',nullable: true)]
    protected $isActivate=false;

    
    protected $plainPassword;
public function __construct()
    {
        $this->generateToken();
    }
public function generateToken(){

    $this->token=str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(random_bytes(128)));
    $this->expiredAt=new \DateTime("+1 day");


    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_VISITEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getExpiredAt(): ?\DateTimeInterface
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(\DateTimeInterface $expiredAt): self
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    public function isIsActivate(): ?bool
    {
        return $this->isActivate;
    }

    public function setIsActivate(bool $isActivate): self
    {
        $this->isActivate = $isActivate;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
