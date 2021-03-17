<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @ApiResource(
 * collectionOperations={
 *    "get"={"path"="/users"},
 *    "post"={
 *          "path"="/user"
 *    }
 *  },
 * itemOperations={
 *    "get"={
 *          "path"="/user/{id}"
 *    },
 *    "getCompteByUserTelephone"={
 *          "method"="get",
 *          "path"="/user/{username}/compte",
 *          "normalization_context"={"groups"={"getCompteByUserTelephone"}}
 *    },
 *    "getUserByUsername"={
 *          "method"="get",
 *          "path"="/user/{username}",
 *          "normalization_context"={"groups"={"getUserByUsername"}}
 *    }
 *  }
 * )
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"getUserByUsername"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"getUserByUsername"})
     */
    private $telephone;

    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getTransByIdUser","getUserByUsername"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getTransByIdUser","getUserByUsername"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getUserByUsername"})
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut = true;

    /**
     * @ORM\ManyToOne(targetEntity=Agences::class, inversedBy="users", cascade="persist")
     * @Groups({"getCompteByUserTelephone"})
     */
    private $agences;

    /**
     * @ORM\OneToMany(targetEntity=Comptes::class, mappedBy="users")
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity=Roles::class, inversedBy="users")
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="usersDepot")
     */
    private $transactionsDepot;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="usersRetrait")
     */
    private $transactionsRetrait;

    public function __construct()
    {
        $this->compte = new ArrayCollection();
        $this->transactionsDepot = new ArrayCollection();
        $this->transactionsRetrait = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->telephone;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->role->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getAgences(): ?Agences
    {
        return $this->agences;
    }

    public function setAgences(?Agences $agences): self
    {
        $this->agences = $agences;

        return $this;
    }

    /**
     * @return Collection|Comptes[]
     */
    public function getCompte(): Collection
    {
        return $this->compte;
    }

    public function addCompte(Comptes $compte): self
    {
        if (!$this->compte->contains($compte)) {
            $this->compte[] = $compte;
            $compte->setUsers($this);
        }

        return $this;
    }

    public function removeCompte(Comptes $compte): self
    {
        if ($this->compte->removeElement($compte)) {
            // set the owning side to null (unless already changed)
            if ($compte->getUsers() === $this) {
                $compte->setUsers(null);
            }
        }

        return $this;
    }

    public function getRole(): ?Roles
    {
        return $this->role;
    }

    public function setRole(?Roles $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Transactions[]
     */
    public function getTransactionsDepot(): Collection
    {
        return $this->transactionsDepot;
    }

    public function addTransactionsDepot(Transactions $transactionsDepot): self
    {
        if (!$this->transactionsDepot->contains($transactionsDepot)) {
            $this->transactionsDepot[] = $transactionsDepot;
            $transactionsDepot->setUsersDepot($this);
        }

        return $this;
    }

    public function removeTransactionsDepot(Transactions $transactionsDepot): self
    {
        if ($this->transactionsDepot->removeElement($transactionsDepot)) {
            // set the owning side to null (unless already changed)
            if ($transactionsDepot->getUsersDepot() === $this) {
                $transactionsDepot->setUsersDepot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transactions[]
     */
    public function getTransactionsRetrait(): Collection
    {
        return $this->transactionsRetrait;
    }

    public function addTransactionsRetrait(Transactions $transactionsRetrait): self
    {
        if (!$this->transactionsRetrait->contains($transactionsRetrait)) {
            $this->transactionsRetrait[] = $transactionsRetrait;
            $transactionsRetrait->setUsersRetrait($this);
        }

        return $this;
    }

    public function removeTransactionsRetrait(Transactions $transactionsRetrait): self
    {
        if ($this->transactionsRetrait->removeElement($transactionsRetrait)) {
            // set the owning side to null (unless already changed)
            if ($transactionsRetrait->getUsersRetrait() === $this) {
                $transactionsRetrait->setUsersRetrait(null);
            }
        }

        return $this;
    }
}
