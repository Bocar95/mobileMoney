<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use App\Repository\TransactionsRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TransactionsRepository::class)
 * @ApiResource(
 *  collectionOperations={
 *    "post"={
 *          "path"="/user/transactions"
 *    }
 *  },
 *  itemOperations={
 *    "get"={
 *          "path"="/user/transaction/code"
 *    },
 *    "getTransByIdUser"={
 *          "methods"="get",
 *          "path"="/user/{id}/transactions"
 *    },
 *    "getTransByIdCompte"={
 *          "methods"="get",
 *          "path"="/admin/compte/{id}/transactions"
 *    },
 *    "put"={
 *          "path"="/user/transactions/retrait"
 *    },
 *    "getFraisByMontant"={
 *          "path"="/user/frais/{montant}"
 *    }
 *  }
 * )
 * @UniqueEntity("codeTrans")
 * @ApiFilter(DateFilter::class, properties={"dateDepot"})
 */
class Transactions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"getTransByCode","getTransByIdUser","getTransByIdCompte"})
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     * @Groups({"getTransByCode","getTransByIdUser","getTransByIdCompte"})
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"getTransByCode","getTransByIdUser","getTransByIdCompte"})
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeTrans;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"getTransByIdUser","getTransByIdCompte"})
     */
    private $frais;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisDepot;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisRetrait;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisEtat;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisSysteme;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="transactionsDepot")
     * @Groups({"getTransByIdUser"})
     */
    private $usersDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="transactionsRetrait")
     * @Groups({"getTransByIdUser"})
     */
    private $usersRetrait;

    /**
     * @ORM\ManyToOne(targetEntity=Clients::class, inversedBy="transactionsRetrait", cascade="persist")
     * @Groups({"getTransByCode"})
     */
    private $clientRetrait;

    /**
     * @ORM\ManyToOne(targetEntity=Clients::class, inversedBy="transactionsDepot", cascade="persist")
     * @Groups({"getTransByCode"})
     */
    private $clientDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Comptes::class, inversedBy="transactionsDepot")
     */
    private $compteDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Comptes::class, inversedBy="transactionsRetrait")
     */
    private $compteRetrait;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(?\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getCodeTrans(): ?string
    {
        return $this->codeTrans;
    }

    public function setCodeTrans(string $codeTrans): self
    {
        $this->codeTrans = $codeTrans;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getFraisDepot(): ?int
    {
        return $this->fraisDepot;
    }

    public function setFraisDepot(int $fraisDepot): self
    {
        $this->fraisDepot = $fraisDepot;

        return $this;
    }

    public function getFraisRetrait(): ?int
    {
        return $this->fraisRetrait;
    }

    public function setFraisRetrait(int $fraisRetrait): self
    {
        $this->fraisRetrait = $fraisRetrait;

        return $this;
    }

    public function getFraisEtat(): ?int
    {
        return $this->fraisEtat;
    }

    public function setFraisEtat(int $fraisEtat): self
    {
        $this->fraisEtat = $fraisEtat;

        return $this;
    }

    public function getFraisSysteme(): ?int
    {
        return $this->fraisSysteme;
    }

    public function setFraisSysteme(int $fraisSysteme): self
    {
        $this->fraisSysteme = $fraisSysteme;

        return $this;
    }

    public function getUsersDepot(): ?Users
    {
        return $this->usersDepot;
    }

    public function setUsersDepot(?Users $usersDepot): self
    {
        $this->usersDepot = $usersDepot;

        return $this;
    }

    public function getUsersRetrait(): ?Users
    {
        return $this->usersRetrait;
    }

    public function setUsersRetrait(?Users $usersRetrait): self
    {
        $this->usersRetrait = $usersRetrait;

        return $this;
    }

    public function getClientRetrait(): ?Clients
    {
        return $this->clientRetrait;
    }

    public function setClientRetrait(?Clients $clientRetrait): self
    {
        $this->clientRetrait = $clientRetrait;

        return $this;
    }

    public function getClientDepot(): ?Clients
    {
        return $this->clientDepot;
    }

    public function setClientDepot(?Clients $clientDepot): self
    {
        $this->clientDepot = $clientDepot;

        return $this;
    }

    public function getCompteDepot(): ?Comptes
    {
        return $this->compteDepot;
    }

    public function setCompteDepot(?Comptes $compteDepot): self
    {
        $this->compteDepot = $compteDepot;

        return $this;
    }

    public function getCompteRetrait(): ?Comptes
    {
        return $this->compteRetrait;
    }

    public function setCompteRetrait(?Comptes $compteRetrait): self
    {
        $this->compteRetrait = $compteRetrait;

        return $this;
    }

}
