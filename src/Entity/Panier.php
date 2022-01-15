<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=MesArticles::class, mappedBy="panier")
     */
    private $mesArticles;

    public function __construct()
    {
        $this->idAchat = new ArrayCollection();
        $this->idUSER = new ArrayCollection();
        $this->mesArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|MesArticles[]
     */
    public function getMesArticles(): Collection
    {
        return $this->mesArticles;
    }

    public function addMesArticle(MesArticles $mesArticle): self
    {
        if (!$this->mesArticles->contains($mesArticle)) {
            $this->mesArticles[] = $mesArticle;
            $mesArticle->setPanier($this);
        }

        return $this;
    }

    public function removeMesArticle(MesArticles $mesArticle): self
    {
        if ($this->mesArticles->removeElement($mesArticle)) {
            // set the owning side to null (unless already changed)
            if ($mesArticle->getPanier() === $this) {
                $mesArticle->setPanier(null);
            }
        }

        return $this;
    }

}
