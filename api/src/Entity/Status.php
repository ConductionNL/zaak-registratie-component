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
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\StatusRepository")
 * @Gedmo\Loggable
 */
class Status
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
     * @var \Ramsey\Uuid\UuidInterface $zaak the zaak which this status belongs to.
	 * 
	 * @Assert\NotNull
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Zaak", inversedBy="statusen")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zaak;

    /**
     * @var string $status_type.
	 * 
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\Column(type="string", length=1000)
     */
    private $status_type;

    /**
     * @var string $datum_status_gezet.
	 * 
     * @Assert\NotNull
     * @Assert\DateTime
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\Column(type="datetime")
     */
    private $datum_status_gezet;

    /**
     * @var string $status_toelichting.
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $status_toelichting;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $url;

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

    public function getStatustype(): ?string
    {
        return $this->status_type;
    }

    public function setStatustype(string $status_type): self
    {
        $this->status_type = $status_type;

        return $this;
    }

    public function getDatumStatusGezet(): ?\DateTimeInterface
    {
        return $this->datum_status_gezet;
    }

    public function setDatumStatusGezet(\DateTimeInterface $datum_status_gezet): self
    {
        $this->datum_status_gezet = $datum_status_gezet;

        return $this;
    }

    public function getStatusToelichting(): ?string
    {
        return $this->status_toelichting;
    }

    public function setStatusToelichting(?string $status_toelichting): self
    {
        $this->status_toelichting = $status_toelichting;

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
