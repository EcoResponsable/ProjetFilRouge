<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Client extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $paiement = [];

    public function __construct()
    {
         $this->setRoles(['client']);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaiement(): ?array
    {
        return $this->paiement;
    }

    public function setPaiement(?array $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }
}
