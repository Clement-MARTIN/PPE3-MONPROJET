<?php

namespace App\Entity;

use App\Repository\AchatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AchatRepository::class)
 */
class Achat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, cascade={"persist", "remove"})
     */
    private $numArticle;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="idAchat")
     */
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getNumArticle(): ?Article
    {
        return $this->numArticle;
    }

    public function setNumArticle(?Article $numArticle): self
    {
        $this->numArticle = $numArticle;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

}
