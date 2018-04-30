<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Entity\Brewery;

use CraftyBrew\WebBundle\Entity\AbstractEntity;
use CraftyBrew\WebBundle\Entity\Brewery;
use CraftyBrew\WebBundle\Entity\EntityDateTrackingTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="brewery_location", indexes={
 *     @ORM\Index(name="idx_brewery_location_brewery_id", columns={"brewery_id"})
 * })
 */
class Location extends AbstractEntity
{
    use EntityDateTrackingTrait;

    /**
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     * @Serializer\Groups({"list"})
     *
     * @var string
     */
    private $address;

    /**
     * @ORM\Column(name="address_extended", type="string", length=255, nullable=true)
     * @Serializer\Groups({"list"})
     *
     * @var string|null
     */
    private $addressExtended;

    /**
     * @ORM\ManyToOne(targetEntity="CraftyBrew\WebBundle\Entity\Brewery", inversedBy="locations")
     * @ORM\JoinColumn(name="brewery_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     *
     * @var Brewery
     */
    private $brewery;

    /**
     * @ORM\Column(name="brewerydb_id", type="string", length=10, unique=true)
     *
     * @var string
     */
    private $brewerydbId;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="bigint", length=20)
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="city", type="string", length=100)
     * @Serializer\Groups({"list"})
     *
     * @var string
     */
    private $city;

    /**
     * @ORM\Column(name="hours", type="text", nullable=true)
     * @Serializer\Groups({"list"})
     *
     * @var string
     */
    private $hours;

    /**
     * @ORM\Column(name="label", type="string", length=255)
     * @Serializer\Groups({"list"})
     *
     * @var string
     */
    private $label;

    /**
     * @ORM\Column(name="latitude", type="decimal", scale=6, precision=8)
     * @Serializer\Groups({"list"})
     *
     * @var float
     */
    private $latitude;

    /**
     * @ORM\Column(name="longitude", type="decimal", scale=6, precision=8)
     * @Serializer\Groups({"list"})
     *
     * @var float
     */
    private $longitude;

    /**
     * @ORM\Column(name="opened", type="integer", length=4, nullable=true)
     * @Serializer\Groups({"list"})
     *
     * @var integer
     */
    private $opened;

    /**
     * @ORM\Column(name="phone", type="string", length=10, nullable=true)
     * @Serializer\Groups({"list"})
     *
     * @var string|null
     */
    private $phone;

    /**
     * @ORM\Column(name="postal", type="string", length=10, nullable=true)
     * @Serializer\Groups({"list"})
     *
     * @var string
     */
    private $postal;

    /**
     * @ORM\Column(name="state", type="string", length=20)
     * @Serializer\Groups({"list"})
     *
     * @var string
     */
    private $state;

    /**
     * @ORM\Column(name="type", type="string", length=10)
     *
     * @var string
     */
    private $type;

    /**
     * Initialize the Brewery object.
     */
    public function __construct()
    {
        $this->dateCreated = new \DateTimeImmutable;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return null|string
     */
    public function getAddressExtended(): ?string
    {
        return $this->addressExtended;
    }

    /**
     * @return Brewery
     */
    public function getBrewery(): Brewery
    {
        return $this->brewery;
    }

    /**
     * @return string
     */
    public function getBrewerydbId(): string
    {
        return $this->brewerydbId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateCreated(): \DateTimeImmutable
    {
        return $this->dateCreated;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateUpdated(): ?\DateTimeImmutable
    {
        return $this->dateUpdated;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getHours(): string
    {
        return $this->hours;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return int
     */
    public function getOpened(): int
    {
        return $this->opened;
    }

    /**
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getPostal(): string
    {
        return $this->postal;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string|null $address
     *
     * @return $this
     */
    public function setAddress(?string $address = null): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @param string|null $addressExtended
     *
     * @return $this
     */
    public function setAddressExtended(?string $addressExtended = null): self
    {
        $this->addressExtended = $addressExtended;

        return $this;
    }

    /**
     * @param Brewery $brewery
     *
     * @return $this
     */
    public function setBrewery(Brewery $brewery): self
    {
        $this->brewery = $brewery;

        return $this;
    }

    /**
     * @param string $brewerydbId
     *
     * @return $this
     */
    public function setBrewerydbId(string $brewerydbId): self
    {
        $this->brewerydbId = $brewerydbId;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $city
     *
     * @return $this
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param string|null $hours
     *
     * @return $this
     */
    public function setHours(?string $hours = null): self
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * @param string $label
     *
     * @return $this
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @param float $latitude
     *
     * @return $this
     */
    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @param float $longitude
     *
     * @return $this
     */
    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @param int|null $opened
     *
     * @return $this
     */
    public function setOpened(?int $opened = null): self
    {
        $this->opened = $opened;

        return $this;
    }

    /**
     * @param string|null $phone
     *
     * @return $this
     */
    public function setPhone(?string $phone = null): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @param string|null $postal
     *
     * @return $this
     */
    public function setPostal(?string $postal = null): self
    {
        $this->postal = $postal;

        return $this;
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
