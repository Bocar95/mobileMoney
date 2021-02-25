<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @ApiResource()
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
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
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut = true;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="users")
     */
    private $transactions;

    /**
     * @ORM\ManyToOne(targetEntity=Agences::class, inversedBy="users")
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

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->compte = new ArrayCollection();
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

    /**
     * @return Collection|Transactions[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transactions $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setUsers($this);
        }

        return $this;
    }

    public function removeTransaction(Transactions $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getUsers() === $this) {
                $transaction->setUsers(null);
            }
        }

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
}
