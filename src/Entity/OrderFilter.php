<?php

namespace App\Entity;

use App\Repository\OrderFilterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderFilterRepository::class)
 */
class OrderFilter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ordre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filtre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdre(): ?string
    {
        return $this->ordre;
    }

    public function setOrdre(string $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getFiltre(): ?string
    {
        return $this->filtre;
    }

    public function setFiltre(string $filtre): self
    {
        $this->filtre = $filtre;

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
