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
 *      denormalizationContext={"groups"={"zaken.bijwerken"}, "enable_max_depth"=true},
 *      collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="rollen"
 *          },
 *          "post"={
 *              "method"="POST",
 *              "path"="rollen"
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="rollen/{uuid}"
 *          },
 *          "delete"={
 *              "method"="DELETE",
 *              "path"="rollen/{uuid}"
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\RolRepository")
 * @Gedmo\Loggable
 */
class Rol
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
     * @var \Ramsey\Uuid\UuidInterface $zaak The Zaak which this Rol belongs to.
	 * 
	 * @Assert\NotNull
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Zaak", inversedBy="rollen")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zaak;

    /**
     * @var string $betrokkene The betrokkene of this Rol.
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $betrokkene;

    /**
     * @var string $betrokkene_type The betrokkenetype of this Rol.
	 * 
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 255
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="string", length=255)
     */
    private $betrokkene_type;

    /**
     * @var string $rol_type The type of this Rol.
	 * 
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="string", length=1000)
     */
    private $rol_type;

    /**
     * @var string $rol_toelichting The toelichting of this Rol.
	 * 
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="string", length=1000)
     */
    private $rol_toelichting;

    /**
     * @var string $indicatie_machtiging The optional inidicatiemachtiging of this Rol.
	 * 
     * @Assert\Length(
     *      max = 255
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $indicatie_machtiging;

    /**
     * @var string $betrokkene_identificatie The identification of the betrokkene of this Rol.
	 * 
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="object", nullable=true)
     */
    private $betrokkene_identificatie;

    /**
     * @var string $url The url of this Rol.
	 * 
     * @Assert\Length(
     *      max = 1000
     * )
     * @Groups({"zaken.lezen","zaken.bijwerken"})
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

    public function getBetrokkene(): ?string
    {
        return $this->betrokkene;
    }

    public function setBetrokkene(?string $betrokkene): self
    {
        $this->betrokkene = $betrokkene;

        return $this;
    }

    public function getBetrokkenetype(): ?string
    {
        return $this->betrokkene_type;
    }

    public function setBetrokkenetype(string $betrokkene_type): self
    {
        $this->betrokkene_type = $betrokkene_type;

        return $this;
    }

    public function getRolType(): ?string
    {
        return $this->rol_type;
    }

    public function setRolType(string $rol_type): self
    {
        $this->rol_type = $rol_type;

        return $this;
    }

    public function getRolToelichting(): ?string
    {
        return $this->rol_toelichting;
    }

    public function setRolToelichting(string $rol_toelichting): self
    {
        $this->rol_toelichting = $rol_toelichting;

        return $this;
    }

    public function getIndicatieMachtiging(): ?string
    {
        return $this->indicatie_machtiging;
    }

    public function setIndicatieMachtiging(?string $indicatie_machtiging): self
    {
        $this->indicatie_machtiging = $indicatie_machtiging;

        return $this;
    }

    public function getBetrokkeneIdentificatie()
    {
        return $this->betrokkene_identificatie;
    }

    public function setBetrokkeneIdentificatie($betrokkene_identificatie): self
    {
        $this->betrokkene_identificatie = $betrokkene_identificatie;

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
