<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_commande;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="commande")
     */
    private $idUSER;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commandes")
     */
    private $isUser;

    /**
     * @ORM\Column(type="json")
     */
    private $Articles = [];

    /**
     * @ORM\Column(type="json")
     */
    private $Quantite = [];

    public function __construct()
    {
        $this->idAchat = new ArrayCollection();
        $this->idUSER = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    /**
     * @return Collection|achat[]
     */
    public function getIdAchat(): Collection
    {
        return $this->idAchat;
    }

    public function addIdAchat(achat $idAchat): self
    {
        if (!$this->idAchat->contains($idAchat)) {
            $this->idAchat[] = $idAchat;
            $idAchat->setCommande($this);
        }

        return $this;
    }

    public function removeIdAchat(achat $idAchat): self
    {
        if ($this->idAchat->removeElement($idAchat)) {
            // set the owning side to null (unless already changed)
            if ($idAchat->getCommande() === $this) {
                $idAchat->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|user[]
     */
    public function getIdUSER(): Collection
    {
        return $this->idUSER;
    }

    public function addIdUSER(user $idUSER): self
    {
        if (!$this->idUSER->contains($idUSER)) {
            $this->idUSER[] = $idUSER;
            $idUSER->setCommande($this);
        }

        return $this;
    }

    public function removeIdUSER(user $idUSER): self
    {
        if ($this->idUSER->removeElement($idUSER)) {
            // set the owning side to null (unless already changed)
            if ($idUSER->getCommande() === $this) {
                $idUSER->setCommande(null);
            }
        }

        return $this;
    }

    public function getIsUser(): ?user
    {
        return $this->isUser;
    }

    public function setIsUser(?user $isUser): self
    {
        $this->isUser = $isUser;

        return $this;
    }

    public function getArticles(): ?array
    {
        return $this->Articles;
    }

    public function setArticles(array $Articles): self
    {
        $this->Articles = $Articles;

        return $this;
    }

    public function getQuantite(): ?array
    {
        return $this->Quantite;
    }

    public function setQuantite(array $Quantite): self
    {
        $this->Quantite = $Quantite;

        return $this;
    }
}
