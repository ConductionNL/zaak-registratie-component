<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatusRepository")
 */
class Status
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zaak", inversedBy="statusen")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zaak;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZaak(): ?zaak
    {
        return $this->zaak;
    }

    public function setZaak(?zaak $zaak): self
    {
        $this->zaak = $zaak;

        return $this;
    }
}
