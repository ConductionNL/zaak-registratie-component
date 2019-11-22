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
 * @ORM\Entity(repositoryClass="App\Repository\ZaakInformatieObjectRepository")
 * @Gedmo\Loggable
 */
class ZaakInformatieObject
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
     * @var \Ramsey\Uuid\UuidInterface $zaak the zaak which this ZIO belongs to.
	 * 
	 * @Assert\NotNull
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Zaak", inversedBy="zaak_informatieobjecten")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zaak;

    /**
     * @var string $informatie_object
     *
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\Column(type="string", length=1000)
     */
    private $informatie_object;

    /**
     * @var string $titel
	 * 
     * @Assert\Length(
     *      max = 200
     * )
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $titel;

    /**
     * @var string $beschrijving
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"read","write"})
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $beschrijving;

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

    public function getInformatieObject(): ?string
    {
        return $this->informatie_object;
    }

    public function setInformatieObject(string $informatie_object): self
    {
        $this->informatie_object = $informatie_object;

        return $this;
    }

    public function getTitel(): ?string
    {
        return $this->titel;
    }

    public function setTitel(?string $titel): self
    {
        $this->titel = $titel;

        return $this;
    }

    public function getBeschrijving(): ?string
    {
        return $this->beschrijving;
    }

    public function setBeschrijving(?string $beschrijving): self
    {
        $this->beschrijving = $beschrijving;

        return $this;
    }
}
