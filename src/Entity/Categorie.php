<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
    private $nameCat;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="categories")
     */
    private $catParent;

    /**
     * @ORM\OneToMany(targetEntity=Categorie::class, mappedBy="catParent")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="idCat")
     */
    private $articles;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCat(): ?string
    {
        return $this->nameCat;
    }

    public function setNameCat(string $nameCat): self
    {
        $this->nameCat = $nameCat;

        return $this;
    }

    public function getCatParent(): ?self
    {
        return $this->catParent;
    }

    public function setCatParent(?self $catParent): self
    {
        $this->catParent = $catParent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(self $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setCatParent($this);
        }

        return $this;
    }

    public function removeCategory(self $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getCatParent() === $this) {
                $category->setCatParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setIdCat($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getIdCat() === $this) {
                $article->setIdCat(null);
            }
        }

        return $this;
    }
}
