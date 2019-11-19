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
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\KlantContactRepository")
 * @Gedmo\Loggable
 */
// Not sure what to do with this:
// @ApiFilter(LikeFilter::class, properties={"onderwerp","toelichting"})
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
	 * @Groups({"read"})
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
	 */
    private $id;

    /**
	 * @var string $zaak the zaak which this KC belongs to.
	 * 
	 * @Assert\NotNull
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Zaak", inversedBy="klantcontacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zaak;

    /**
	 * @var string $datumtijd the datetime of this KC.
	 * 
	 * @Assert\NotNull
     * @Assert\DateTime
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\Column(type="datetime")
     */
    private $datumtijd;

    /**
	 * @var string $kanaal the kanaal of this KC.
	 * 
     * @Assert\Length(
     *      max = 20
     * )
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $kanaal;

    /**
     * @var string $onderwerp the onderwerp of this KC.
	 * 
     * @Assert\Length(
     *      max = 200
     * )
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $onderwerp;

    /**
     * @var string $toelichting the toelichting of this KC.
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $toelichting;

    /**
     * @var string $url the url of this KC.
	 * 
     * @Assert\Length(
     *      max = 255
     * )
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\Column(type="string", length=255)
     */
    private $url;

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
}
