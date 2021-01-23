<?php

namespace App\Entity;

use App\Repository\ConnexionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConnexionRepository::class)
 */
class Connexion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateConnexion;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="connexions")
     */
    protected $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    // commentaire test
    public function getDateConnexion(): ?\DateTimeInterface
    {
        return $this->dateConnexion;
    }

    public function setDateConnexion(\DateTimeInterface $dateConnexion): self
    {
        $this->dateConnexion = $dateConnexion;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
