<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientsRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  itemOperations={
 *    "get"={
 *          "path"="/user/client/{id}"
 *    },
 *    "getClientByNci"={
 *          "methods"="get",
 *          "path"="/user/client/{nci}"
 *    }
 *  }
 * )
 * @ORM\Entity(repositoryClass=ClientsRepository::class)
 */
class Clients
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getTransByCode","getClientByNci","getDepotTransByIdUser","getRetraitTransByIdUser"})
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getTransByCode","getClientByNci"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     * @Groups({"getTransByCode"})
     */
    private $numCni;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="clientRetrait", cascade="persist")
     */
    private $transactionsRetrait;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="clientDepot", cascade="persist")
     */
    private $transactionsDepot;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->transactionsRetrait = new ArrayCollection();
        $this->transactionsDepot = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
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

    public function getNumCni(): ?string
    {
        return $this->numCni;
    }

    public function setNumCni(string $numCni): self
    {
        $this->numCni = $numCni;

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
            $transactionsRetrait->setClientRetrait($this);
        }

        return $this;
    }

    public function removeTransactionsRetrait(Transactions $transactionsRetrait): self
    {
        if ($this->transactionsRetrait->removeElement($transactionsRetrait)) {
            // set the owning side to null (unless already changed)
            if ($transactionsRetrait->getClientRetrait() === $this) {
                $transactionsRetrait->setClientRetrait(null);
            }
        }

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
            $transactionsDepot->setClientDepot($this);
        }

        return $this;
    }

    public function removeTransactionsDepot(Transactions $transactionsDepot): self
    {
        if ($this->transactionsDepot->removeElement($transactionsDepot)) {
            // set the owning side to null (unless already changed)
            if ($transactionsDepot->getClientDepot() === $this) {
                $transactionsDepot->setClientDepot(null);
            }
        }

        return $this;
    }

}
