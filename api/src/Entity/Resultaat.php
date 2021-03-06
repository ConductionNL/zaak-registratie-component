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
 *              "path"="/resultaten"
 *          },
 *          "post"={
 *              "method"="POST",
 *              "path"="/resultaten"
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/resultaten/{uuid}"
 *          },
 *          "put"={
 *              "method"="PUT",
 *              "path"="/resultaten/{uuid}"
 *          },
 *          "patch"={
 *              "method"="PATCH",
 *              "path"="/resultaten/{uuid}"
 *          },
 *          "delete"={
 *              "method"="DELETE",
 *              "path"="/resultaten/{uuid}"
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ResultaatRepository")
 * @Gedmo\Loggable
 */
class Resultaat
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
     * @var \Ramsey\Uuid\UuidInterface $zaak The Zaak which this Resultaat belongs to.
	 * 
	 * @Assert\NotNull
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Zaak", inversedBy="resultaten")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zaak;

    /**
     * @var string $resultaattype The resultaattype of this Resultaat.
	 * 
	 * @Assert\NotNull
     * @Assert\Length(
     *      max = 1000
     * )
     * @Gedmo\Versioned
	 * @Groups({"zaken.lezen","zaken.bijwerken"})
     * @ORM\Column(type="string", length=1000)
     */
    private $resultaat_type;

    /**
     * @var string $toelichting The optional toelichting of this Resultaat.
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
     * @var string $url The url of this Resultaat.
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

    public function getResultaattype(): ?string
    {
        return $this->resultaat_type;
    }

    public function setResultaattype(string $resultaat_type): self
    {
        $this->resultaat_type = $resultaat_type;

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
