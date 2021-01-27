<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{

    public function __construct()
    {
        $this->setTVA(0.055);
        $this->produitPaniers = new ArrayCollection();
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $poidUnitaire;

    /**
     * @ORM\Column(type="float")
     */
    private $prixUnitaireHT;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $TVA;

    /**
     * @ORM\ManyToOne(targetEntity=Vendeur::class, inversedBy="produits")
     */
    private $vendeur;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="produit")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=ProduitPanier::class, mappedBy="produit")
     */
    private $produitPaniers;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPoidUnitaire(): ?int
    {
        return $this->poidUnitaire;
    }

    public function setPoidUnitaire(int $poidUnitaire): self
    {
        $this->poidUnitaire = $poidUnitaire;

        return $this;
    }

    public function getPrixUnitaireHT(): ?float
    {
        return $this->prixUnitaireHT;
    }

    public function setPrixUnitaireHT(float $prixUnitaireHT): self
    {
        $this->prixUnitaireHT = $prixUnitaireHT;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTVA(): ?float
    {
        return $this->TVA;
    }

    public function setTVA(float $TVA): self
    {
        $this->TVA = $TVA;

        return $this;
    }

    public function getVendeur(): ?Vendeur
    {
        return $this->vendeur;
    }

    public function setVendeur(?Vendeur $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|ProduitPanier[]
     */
    public function getProduitPaniers(): Collection
    {
        return $this->produitPaniers;
    }

    public function addProduitPanier(ProduitPanier $produitPanier): self
    {
        if (!$this->produitPaniers->contains($produitPanier)) {
            $this->produitPaniers[] = $produitPanier;
            $produitPanier->setProduit($this);
        }

        return $this;
    }

    public function removeProduitPanier(ProduitPanier $produitPanier): self
    {
        if ($this->produitPaniers->removeElement($produitPanier)) {
            // set the owning side to null (unless already changed)
            if ($produitPanier->getProduit() === $this) {
                $produitPanier->setProduit(null);
            }
        }

        return $this;
    }
}
