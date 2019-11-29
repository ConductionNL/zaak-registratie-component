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
use Ramsey\Uuid\Uuid;


/**
 * @ApiResource(
 *      normalizationContext={"groups"={"zaken.lezen"}, "enable_max_depth"=true},
 *      denormalizationContext={"groups"={"zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"}, "enable_max_depth"=true},
 *      collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/zaken"
 *          },
 *          "post"={
 *              "method"="POST",
 *              "path"="/zaken"
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/zaken/{uuid}"
 *          },
 *          "put"={
 *              "method"="PUT",
 *              "path"="/zaken/{uuid}"
 *          },
 *          "patch"={
 *              "method"="PATCH",
 *              "path"="/zaken/{uuid}"
 *          },
 *          "delete"={
 *              "method"="DELETE",
 *              "path"="/zaken/{uuid}"
 *          }
 *      }
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
	 * @Groups({"zaken.lezen"})
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
     * @var string $url The url of this Zaak.
	 * 
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=1000)
     */
    private $url;

    /**
     * @var string $bronorganisatie The source organization of this Zaak.
	 * 
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 9
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=9)
     */
    private $bronorganisatie;

    /**
     * @var string $omschrijving The omschrijving of this Zaak.
	 * 
     * @Assert\Length(
     *      max = 80
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $omschrijving;

    /**
     * @var string $toelichting The optional toelichting of this Zaak.
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $toelichting;

    /**
     * @var string $zaak_type The type of this Zaak.
	 * 
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=1000)
     */
    private $zaak_type;

    /**
     * @var string $registratie_datum The registration date of this Zaak.
	 * 
     * @Assert\Date
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="date", nullable=true)
     */
    private $registratie_datum;

    /**
     * @var string $verantwoordelijke_organisatie The verantwoordelijke organisatie of this Zaak.
	 * 
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 9
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=9)
     */
    private $verantwoordelijke_organisatie;

    /**
     * @var string $start_datum The start date of this Zaak.
	 * 
     * @Assert\NotNull
     * @Assert\Date
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="date")
     */
    private $start_datum;

    /**
     * @var string $einddatum_gepland The planned end-date of this Zaak.
	 * 
     * @Assert\Date
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="date", nullable=true)
     */
    private $einddatum_gepland;

    /**
     * @var string $uiterlijke_einddatum_afdoening The uiterlijke einddatum afdoening of this Zaak.
	 * 
     * @Assert\Date
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="date", nullable=true)
     */
    private $uiterlijke_einddatum_afdoening;

    /**
     * @var string $publicatie_datum The publicatiedatum of this Zaak.
	 * 
     * @Assert\Date
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="date", nullable=true)
     */
    private $publicatie_datum;

    /**
     * @var string $communicatie_kanaal The communicatiekanaal of this Zaak.
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $communicatie_kanaal;

    /**
     * @var string $producten_of_diensten The producten of diensten of this Zaak.
	 * 
     * @Assert\Collection
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="array", nullable=true)
     */
    private $producten_of_diensten = [];

    /**
     * @var string $vertrouwelijkheid_aanduiding The vertrouwelijkheid aanduiding of this Zaak.
	 * 
     * @Assert\Length(
     *      max = 255
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vertrouwelijkheid_aanduiding;

    /**
     * @var string $betalingsindicatie The betalingsindicatie of this Zaak.
	 * 
     * @Assert\Length(
     *      max = 255
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $betalingsindicatie;

    /**
     * @var string $laatste_betaaldatum The laatste betaaldatum of this Zaak.
	 * 
     * @Assert\DateTime
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $laatste_betaaldatum;

    /**
     * @var string $zaak_geometrie The geometrie of this Zaak.
	 * 
     * @Assert\Collection
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="object", nullable=true)
     */
    private $zaak_geometrie;

    /**
     * @var string $verlenging The verlenging of this Zaak.
	 * 
     * @Assert\Collection
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="object", nullable=true)
     */
    private $verlenging;

    /**
     * @var string $opschorting The opschorting of this Zaak.
	 * 
     * @Assert\Collection
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="object", nullable=true)
     */
    private $opschorting;

    /**
     * @var string $selectielijstklasse The selectielijstklasse of this Zaak.
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $selectielijstklasse;

    /**
     * @var string $hoofdzaak The hoofdzaak of this Zaak.
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $hoofdzaak;

    /**
     * @var string $relevante_andere_zaken The relevante andere zaken of this Zaak.
	 * 
     * @Assert\Collection
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="array", nullable=true)
     */
    private $relevante_andere_zaken = [];

    /**
     * @var string $kenmerken The kenmerken of this Zaak.
	 * 
     * @Assert\Collection
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="array", nullable=true)
     */
    private $kenmerken = [];

    /**
     * @var string $archief_nominatie The archief nominatie of this Zaak.
	 * 
     * @Assert\Length(
     *      max = 255
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $archief_nominatie;

    /**
     * @var string $archief_status The archief status of this Zaak.
	 * 
     * @Assert\Length(
     *      max = 255
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $archief_status;

    /**
     * @var string $archief_actiedatum The archief actiedatum of this Zaak.
	 * 
     * @Assert\Date
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="date", nullable=true)
     */
    private $archief_actiedatum;

    /**
     * @var string $identificatie The identificatie of this Zaak.
	 * 
     * @Assert\Length(
     *      max = 40
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken", "zaken.geforceerd-bijwerken", "zaken.verwijderen"})
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $identificatie;

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

    public function getBronorganisatie(): ?string
    {
        return $this->bronorganisatie;
    }

    public function setBronorganisatie(string $bronorganisatie): self
    {
        $this->bronorganisatie = $bronorganisatie;

        return $this;
    }

    public function getOmschrijving(): ?string
    {
        return $this->omschrijving;
    }

    public function setOmschrijving(?string $omschrijving): self
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }

    public function getToelichting(): ?string
    {
        return $this->toelichting;
    }

    public function setToelichting(?string $toelichting): self
    {
        $this->toelichting = $toelichting;

        return $this;
    }

    public function getZaakType(): ?string
    {
        return $this->zaak_type;
    }

    public function setZaakType(string $zaak_type): self
    {
        $this->zaak_type = $zaak_type;

        return $this;
    }

    public function getRegistratieDatum(): ?\DateTimeInterface
    {
        return $this->registratie_datum;
    }

    public function setRegistratieDatum(?\DateTimeInterface $registratie_datum): self
    {
        $this->registratie_datum = $registratie_datum;

        return $this;
    }

    public function getVerantwoordelijkeOrganisatie(): ?string
    {
        return $this->verantwoordelijke_organisatie;
    }

    public function setVerantwoordelijkeOrganisatie(string $verantwoordelijke_organisatie): self
    {
        $this->verantwoordelijke_organisatie = $verantwoordelijke_organisatie;

        return $this;
    }

    public function getStartDatum(): ?\DateTimeInterface
    {
        return $this->start_datum;
    }

    public function setStartDatum(\DateTimeInterface $start_datum): self
    {
        $this->start_datum = $start_datum;

        return $this;
    }

    public function getEinddatumGepland(): ?\DateTimeInterface
    {
        return $this->einddatum_gepland;
    }

    public function setEinddatumGepland(?\DateTimeInterface $einddatum_gepland): self
    {
        $this->einddatum_gepland = $einddatum_gepland;

        return $this;
    }

    public function getUiterlijkeEinddatumAfdoening(): ?\DateTimeInterface
    {
        return $this->uiterlijke_einddatum_afdoening;
    }

    public function setUiterlijkeEinddatumAfdoening(?\DateTimeInterface $uiterlijke_einddatum_afdoening): self
    {
        $this->uiterlijke_einddatum_afdoening = $uiterlijke_einddatum_afdoening;

        return $this;
    }

    public function getPublicatieDatum(): ?\DateTimeInterface
    {
        return $this->publicatie_datum;
    }

    public function setPublicatieDatum(?\DateTimeInterface $publicatie_datum): self
    {
        $this->publicatie_datum = $publicatie_datum;

        return $this;
    }

    public function getCommunicatieKanaal(): ?string
    {
        return $this->communicatie_kanaal;
    }

    public function setCommunicatieKanaal(?string $communicatie_kanaal): self
    {
        $this->communicatie_kanaal = $communicatie_kanaal;

        return $this;
    }

    public function getProductenOfDiensten(): ?array
    {
        return $this->producten_of_diensten;
    }

    public function setProductenOfDiensten(?array $producten_of_diensten): self
    {
        $this->producten_of_diensten = $producten_of_diensten;

        return $this;
    }

    public function getVertrouwelijkheidAanduiding(): ?string
    {
        return $this->vertrouwelijkheid_aanduiding;
    }

    public function setVertrouwelijkheidAanduiding(?string $vertrouwelijkheid_aanduiding): self
    {
        $this->vertrouwelijkheid_aanduiding = $vertrouwelijkheid_aanduiding;

        return $this;
    }

    public function getBetalingsindicatie(): ?string
    {
        return $this->betalingsindicatie;
    }

    public function setBetalingsindicatie(?string $betalingsindicatie): self
    {
        $this->betalingsindicatie = $betalingsindicatie;

        return $this;
    }

    public function getLaatsteBetaaldatum(): ?\DateTimeInterface
    {
        return $this->laatste_betaaldatum;
    }

    public function setLaatsteBetaaldatum(?\DateTimeInterface $laatste_betaaldatum): self
    {
        $this->laatste_betaaldatum = $laatste_betaaldatum;

        return $this;
    }

    public function getZaakGeometrie()
    {
        return $this->zaak_geometrie;
    }

    public function setZaakGeometrie($zaak_geometrie): self
    {
        $this->zaak_geometrie = $zaak_geometrie;

        return $this;
    }

    public function getVerlenging()
    {
        return $this->verlenging;
    }

    public function setVerlenging($verlenging): self
    {
        $this->verlenging = $verlenging;

        return $this;
    }

    public function getOpschorting()
    {
        return $this->opschorting;
    }

    public function setOpschorting($opschorting): self
    {
        $this->opschorting = $opschorting;

        return $this;
    }

    public function getSelectielijstklasse(): ?string
    {
        return $this->selectielijstklasse;
    }

    public function setSelectielijstklasse(?string $selectielijstklasse): self
    {
        $this->selectielijstklasse = $selectielijstklasse;

        return $this;
    }

    public function getHoofdzaak(): ?string
    {
        return $this->hoofdzaak;
    }

    public function setHoofdzaak(?string $hoofdzaak): self
    {
        $this->hoofdzaak = $hoofdzaak;

        return $this;
    }

    public function getRelevanteAndereZaken(): ?array
    {
        return $this->relevante_andere_zaken;
    }

    public function setRelevanteAndereZaken(?array $relevante_andere_zaken): self
    {
        $this->relevante_andere_zaken = $relevante_andere_zaken;

        return $this;
    }

    public function getKenmerken(): ?array
    {
        return $this->kenmerken;
    }

    public function setKenmerken(?array $kenmerken): self
    {
        $this->kenmerken = $kenmerken;

        return $this;
    }

    public function getArchiefNominatie(): ?string
    {
        return $this->archief_nominatie;
    }

    public function setArchiefNominatie(?string $archief_nominatie): self
    {
        $this->archief_nominatie = $archief_nominatie;

        return $this;
    }

    public function getArchiefStatus(): ?string
    {
        return $this->archief_status;
    }

    public function setArchiefStatus(?string $archief_status): self
    {
        $this->archief_status = $archief_status;

        return $this;
    }

    public function getArchiefActiedatum(): ?\DateTimeInterface
    {
        return $this->archief_actiedatum;
    }

    public function setArchiefActiedatum(?\DateTimeInterface $archief_actiedatum): self
    {
        $this->archief_actiedatum = $archief_actiedatum;

        return $this;
    }

    public function getIdentificatie(): ?string
    {
        return $this->identificatie;
    }

    public function setIdentificatie(?string $identificatie): self
    {
        $this->identificatie = $identificatie;

        return $this;
    }
}
