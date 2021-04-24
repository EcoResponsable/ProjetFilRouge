<?php

namespace App\Entity;

use App\Repository\RechercheRepository;


class Recherche
{
    /**
   *
     */
    private $id;

    /**
     * 
     */
    private $nom;

    /**
     * 
     */
    private $prixMin;

    /**
     * 
     */
    private $prixMax;

    /**
     * 
     */
    private $stockMin;
    
    private $stockMax;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrixMin(): ?int
    {
        return $this->prixMin;
    }

    public function setPrixMin(?int $prixMin): self
    {
        $this->prixMin = $prixMin;

        return $this;
    }

    public function getPrixMax(): ?int
    {
        return $this->prixMax;
    }

    public function setPrixMax(?int $prixMax): self
    {
        $this->prixMax = $prixMax;

        return $this;
    }

    public function getStockMin(): ?int
    {
        return $this->stockMin;
    }

    public function setStockMin(?int $stockMin): self
    {
        $this->stockMin = $stockMin;

        return $this;
    }

    public function getStockMax(): ?int
    {
        return $this->stockMax;
    }

    public function setStockMax(?int $stockMax): self
    {
        $this->stockMax = $stockMax;

        return $this;
    }
}
