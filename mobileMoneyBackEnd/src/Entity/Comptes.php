<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComptesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ComptesRepository::class)
 */
class Comptes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroCompte;

    /**
     * @ORM\Column(type="integer")
     */
    private $solde;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="compte")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="compteDepot")
     */
    private $transactionsDepot;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="compteRetrait")
     */
    private $transactionsRetrait;

    /**
     * @ORM\OneToOne(targetEntity=Agences::class, mappedBy="compte", cascade={"persist", "remove"})
     */
    private $agences;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->transactionsDepot = new ArrayCollection();
        $this->transactionsRetrait = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

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

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

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
            $transactionsDepot->setCompteDepot($this);
        }

        return $this;
    }

    public function removeTransactionsDepot(Transactions $transactionsDepot): self
    {
        if ($this->transactionsDepot->removeElement($transactionsDepot)) {
            // set the owning side to null (unless already changed)
            if ($transactionsDepot->getCompteDepot() === $this) {
                $transactionsDepot->setCompteDepot(null);
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
            $transactionsRetrait->setCompteRetrait($this);
        }

        return $this;
    }

    public function removeTransactionsRetrait(Transactions $transactionsRetrait): self
    {
        if ($this->transactionsRetrait->removeElement($transactionsRetrait)) {
            // set the owning side to null (unless already changed)
            if ($transactionsRetrait->getCompteRetrait() === $this) {
                $transactionsRetrait->setCompteRetrait(null);
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
        // unset the owning side of the relation if necessary
        if ($agences === null && $this->agences !== null) {
            $this->agences->setCompte(null);
        }

        // set the owning side of the relation if necessary
        if ($agences !== null && $agences->getCompte() !== $this) {
            $agences->setCompte($this);
        }

        $this->agences = $agences;

        return $this;
    }

}
