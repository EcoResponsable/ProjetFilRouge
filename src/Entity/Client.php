<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client extends User
{

    public function __construct()
    {
        $this->setRoles(['ROLE_CLIENT']);
    }
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="array")
     */
    private $adresse = [];

    /**
     * @ORM\Column(type="array")
     */
    private $paiement = [];

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?array
    {
        return $this->adresse;
    }

    public function setAdresse(array $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPaiement(): ?array
    {
        return $this->paiement;
    }

    public function setPaiement(array $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }

}
