<?php

namespace App\Entity;

use App\Repository\PanierRepository;
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
     * @ORM\Column(type="float")
     */
    private $prixTotalTTC;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="paniers")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=ProduitPanier::class, mappedBy="panier")
     */
    private $produitPaniers;

    public function __construct()
    {
        $this->produitPaniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixTotalTTC(): ?float
    {
        return $this->prixTotalTTC;
    }

    public function setPrixTotalTTC(float $prixTotalTTC): self
    {
        $this->prixTotalTTC = $prixTotalTTC;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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
            $produitPanier->setPanier($this);
        }

        return $this;
    }

    public function removeProduitPanier(ProduitPanier $produitPanier): self
    {
        if ($this->produitPaniers->removeElement($produitPanier)) {
            // set the owning side to null (unless already changed)
            if ($produitPanier->getPanier() === $this) {
                $produitPanier->setPanier(null);
            }
        }

        return $this;
    }

    public function addProduit(Produit $produit)
    {
        $produitPanier = new ProduitPanier();
        $produitPanier
        ->setProduit($produit)
        ->setPanier($this);
        
    }
}
