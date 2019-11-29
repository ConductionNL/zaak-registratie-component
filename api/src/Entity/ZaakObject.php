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
 *      normalizationContext={"groups"={"zaken.lezen"}, "enable_max_depth"=true},
 *      denormalizationContext={"groups"={"zaken.aanmaken", "zaken.bijwerken"}, "enable_max_depth"=true},
 *      collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="zaakobjecten"
 *          },
 *          "post"={
 *              "method"="POST",
 *              "path"="zaakobjecten"
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="zaakobjecten/{uuid}"
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ZaakObjectRepository")
 * @Gedmo\Loggable
 */
class ZaakObject
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
     * @var \Ramsey\Uuid\UuidInterface $zaak The Zaak which this ZaakObject belongs to.
	 * 
	 * @Assert\NotNull
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Zaak", inversedBy="zaakobjecten")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zaak;

    /**
     * @var string $object The object of this ZaakObject.
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken"})
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $object;

    /**
     * @var string $betrokkene The betrokkene of this ZaakObject.
	 * 
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 255
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken"})
     * @ORM\Column(type="string", length=255)
     */
    private $objectType;

    /**
     * @var string $object_type_overige Additional information on the object type.
	 * 
     * @Assert\Length(
     *      max = 100
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken"})
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $object_type_overige;

    /**
     * @var string $relatie_omschrijving The omschrijving of the relation.
	 * 
     * @Assert\Length(
     *      max = 80
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken"})
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $relatie_omschrijving;

    /**
     * @var string $object_identificatie The object identifier.
	 * 
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken"})
     * @ORM\Column(type="object", nullable=true)
     */
    private $object_identificatie;

    /**
     * @var string $url The url of this ZaakObject.
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Groups({"zaken.lezen", "zaken.aanmaken", "zaken.bijwerken"})
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

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(?string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getObjectType(): ?string
    {
        return $this->objectType;
    }

    public function setObjectType(string $objectType): self
    {
        $this->objectType = $objectType;

        return $this;
    }

    public function getObjectTypeOverige(): ?string
    {
        return $this->object_type_overige;
    }

    public function setObjectTypeOverige(?string $object_type_overige): self
    {
        $this->object_type_overige = $object_type_overige;

        return $this;
    }

    public function getRelatieOmschrijving(): ?string
    {
        return $this->relatie_omschrijving;
    }

    public function setRelatieOmschrijving(?string $relatie_omschrijving): self
    {
        $this->relatie_omschrijving = $relatie_omschrijving;

        return $this;
    }

    public function getObjectIdentificatie()
    {
        return $this->object_identificatie;
    }

    public function setObjectIdentificatie($object_identificatie): self
    {
        $this->object_identificatie = $object_identificatie;

        return $this;
    }
}
