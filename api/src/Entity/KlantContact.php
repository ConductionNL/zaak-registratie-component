<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
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
 *      denormalizationContext={"groups"={"zaken.bijwerken"}, "enable_max_depth"=true},
 *      collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/klantcontacten"
 *          },
 *          "post"={
 *              "method"="POST",
 *              "path"="/klantcontacten"
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/klantcontacten/{uuid}"
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\KlantContactRepository")
 * @Gedmo\Loggable
 */
class KlantContact
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
	 * @var \Ramsey\Uuid\UuidInterface $zaak The Zaak which this Klantcontact belongs to.
	 * 
	 * @Assert\NotNull
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Zaak", inversedBy="klantcontacten")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zaak;

    /**
	 * @var string $datumtijd The datetime of this Klantcontact.
	 * 
	 * @Assert\NotNull
     * @Assert\DateTime
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="datetime")
     */
    private $datumtijd;

    /**
	 * @var string $kanaal The kanaal of this Klantcontact.
	 * 
     * @Assert\Length(
     *      max = 20
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $kanaal;

    /**
     * @var string $onderwerp The onderwerp of this Klantcontact.
	 * 
     * @Assert\Length(
     *      max = 200
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $onderwerp;

    /**
     * @var string $toelichting The toelichting of this Klantcontact.
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $toelichting;

    /**
     * @var string $url The url of this Klantcontact.
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="string", length=1000)
     */
    private $url;

    /**
     * @var string $url The identificatie of this Klantcontact.
	 * 
     * @Assert\Length(
     *      max = 14
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="string", length=14, nullable=true)
     */
    private $identificatie;

    public function getId(): ?uuid
    {
        return $this->id;
    }

    public function setId(uuid $id): ?uuid
    {
        $this->id = $id;
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

    public function getDatumtijd(): ?\DateTimeInterface
    {
        return $this->datumtijd;
    }

    public function setDatumtijd(\DateTimeInterface $datumtijd): self
    {
        $this->datumtijd = $datumtijd;

        return $this;
    }

    public function getKanaal(): ?string
    {
        return $this->kanaal;
    }

    public function setKanaal(?string $kanaal): self
    {
        $this->kanaal = $kanaal;

        return $this;
    }

    public function getOnderwerp(): ?string
    {
        return $this->onderwerp;
    }

    public function setOnderwerp(?string $onderwerp): self
    {
        $this->onderwerp = $onderwerp;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
