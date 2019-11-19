<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use App\Entity\Zaak;
use Ramsey\Uuid\UuidInterface;


/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ZaakRepository")
 * @Gedmo\Loggable
 */
class Zaak
{
    /**
	 * @var \Ramsey\Uuid\UuidInterface
	 *
	 * @ApiProperty(
	 * 	   identifier=true,
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The UUID identifier of this object",
	 *             "type"="string",
	 *             "format"="uuid",
	 *             "example"="e2984465-190a-4562-829e-a8cca81aa35d"
	 *         }
	 *     }
	 * )
	 *
	 * @Assert\Uuid
	 * @Groups({"read"})
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
	 */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\KlantContact", mappedBy="zaak")
     */
    private $klantcontacten;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Resultaat", mappedBy="zaak")
     */
    private $resultaten;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rol", mappedBy="zaak")
     */
    private $rollen;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Status", mappedBy="zaak")
     */
    private $statusen;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ZaakInformatieObject", mappedBy="zaak")
     */
    private $zaak_informatieobjecten;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ZaakObject", mappedBy="zaak")
     */
    private $zaakobjecten;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    public function __construct()
    {
        $this->klantcontacten = new ArrayCollection();
        $this->resultaten = new ArrayCollection();
        $this->rollen = new ArrayCollection();
        $this->statusen = new ArrayCollection();
        $this->zaak_informatieobjecten = new ArrayCollection();
        $this->zaakobjecten = new ArrayCollection();
    }

    public function getId(): ?uuid
    {
        return $this->id;
    }

    /**
     * @return Collection|Klantcontact[]
     */
    public function getKlantcontacten(): Collection
    {
        return $this->klantcontacten;
    }

    public function addKlantcontacten(Klantcontact $klantcontacten): self
    {
        if (!$this->klantcontacten->contains($klantcontacten)) {
            $this->klantcontacten[] = $klantcontacten;
            $klantcontacten->setZaak($this);
        }

        return $this;
    }

    public function removeKlantcontacten(Klantcontact $klantcontacten): self
    {
        if ($this->klantcontacten->contains($klantcontacten)) {
            $this->klantcontacten->removeElement($klantcontacten);
            // set the owning side to null (unless already changed)
            if ($klantcontacten->getZaak() === $this) {
                $klantcontacten->setZaak(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Resultaat[]
     */
    public function getResultaten(): Collection
    {
        return $this->resultaten;
    }

    public function addResultaten(Resultaat $resultaten): self
    {
        if (!$this->resultaten->contains($resultaten)) {
            $this->resultaten[] = $resultaten;
            $resultaten->setZaak($this);
        }

        return $this;
    }

    public function removeResultaten(Resultaat $resultaten): self
    {
        if ($this->resultaten->contains($resultaten)) {
            $this->resultaten->removeElement($resultaten);
            // set the owning side to null (unless already changed)
            if ($resultaten->getZaak() === $this) {
                $resultaten->setZaak(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rol[]
     */
    public function getRollen(): Collection
    {
        return $this->rollen;
    }

    public function addRollen(Rol $rollen): self
    {
        if (!$this->rollen->contains($rollen)) {
            $this->rollen[] = $rollen;
            $rollen->setZaak($this);
        }

        return $this;
    }

    public function removeRollen(Rol $rollen): self
    {
        if ($this->rollen->contains($rollen)) {
            $this->rollen->removeElement($rollen);
            // set the owning side to null (unless already changed)
            if ($rollen->getZaak() === $this) {
                $rollen->setZaak(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Status[]
     */
    public function getStatusen(): Collection
    {
        return $this->statusen;
    }

    public function addStatusen(Status $statusen): self
    {
        if (!$this->statusen->contains($statusen)) {
            $this->statusen[] = $statusen;
            $statusen->setZaak($this);
        }

        return $this;
    }

    public function removeStatusen(Status $statusen): self
    {
        if ($this->statusen->contains($statusen)) {
            $this->statusen->removeElement($statusen);
            // set the owning side to null (unless already changed)
            if ($statusen->getZaak() === $this) {
                $statusen->setZaak(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Zaakinformatieobject[]
     */
    public function getZaakInformatieobjecten(): Collection
    {
        return $this->zaak_informatieobjecten;
    }

    public function addZaakInformatieobjecten(Zaakinformatieobject $zaakInformatieobjecten): self
    {
        if (!$this->zaak_informatieobjecten->contains($zaakInformatieobjecten)) {
            $this->zaak_informatieobjecten[] = $zaakInformatieobjecten;
            $zaakInformatieobjecten->setZaak($this);
        }

        return $this;
    }

    public function removeZaakInformatieobjecten(Zaakinformatieobject $zaakInformatieobjecten): self
    {
        if ($this->zaak_informatieobjecten->contains($zaakInformatieobjecten)) {
            $this->zaak_informatieobjecten->removeElement($zaakInformatieobjecten);
            // set the owning side to null (unless already changed)
            if ($zaakInformatieobjecten->getZaak() === $this) {
                $zaakInformatieobjecten->setZaak(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Zaakobject[]
     */
    public function getZaakobjecten(): Collection
    {
        return $this->zaakobjecten;
    }

    public function addZaakobjecten(Zaakobject $zaakobjecten): self
    {
        if (!$this->zaakobjecten->contains($zaakobjecten)) {
            $this->zaakobjecten[] = $zaakobjecten;
            $zaakobjecten->setZaak($this);
        }

        return $this;
    }

    public function removeZaakobjecten(Zaakobject $zaakobjecten): self
    {
        if ($this->zaakobjecten->contains($zaakobjecten)) {
            $this->zaakobjecten->removeElement($zaakobjecten);
            // set the owning side to null (unless already changed)
            if ($zaakobjecten->getZaak() === $this) {
                $zaakobjecten->setZaak(null);
            }
        }

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
