<?php

namespace App\Entity;

use App\Repository\AchatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AchatRepository::class)
 */
class MesArticles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, cascade={"persist", "remove"})
     */
    private $numArticle;

    /**
     * @ORM\ManyToOne(targetEntity=Panier::class, inversedBy="mesArticles")
     */
    private $panier;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $achat;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPanier(): ?panier
    {
        return $this->panier;
    }

    public function setPanier(?panier $panier): self
    {
        $this->panier = $panier;

        return $this;
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

    public function getAchat(): ?int
    {
        return $this->achat;
    }

    public function setAchat(int $achat): self
    {
        $this->achat = $achat;

        return $this;
    }
}