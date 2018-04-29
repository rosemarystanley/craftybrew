<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="brewery")
 */
class Brewery extends AbstractEntity
{
    use EntityDateTrackingTrait;

    /**
     * @ORM\Column(name="brewerydb_id", type="string", length=10, unique=true)
     *
     * @var string
     */
    private $brewerydbId;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(name="established", type="integer", length=4, nullable=true)
     *
     * @var integer
     */
    private $established;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="bigint", length=20)
     * @Annotation\Groups({"list"})
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="CraftyBrew\WebBundle\Entity\Brewery\Location", mappedBy="brewery", cascade={"persist"})
     *
     * @var Brewery\Location[]|Collection
     */
    private $locations;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @Annotation\Groups({"list"})
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="organic", type="boolean", options={"default": false})
     *
     * @var bool
     */
    private $organic = false;

    /**
     * @ORM\OneToMany(targetEntity="CraftyBrew\WebBundle\Entity\Brewery\Url", mappedBy="brewery", cascade={"persist"})
     * @Annotation\Groups({"list"})
     *
     * @var Brewery\Url[]|Collection
     */
    private $urls;

    /**
     * Initialize the Brewery object.
     */
    public function __construct()
    {
        $this->urls = new ArrayCollection;
        $this->dateCreated = new \DateTimeImmutable;
    }

    /**
     * @param Brewery\Location $location
     *
     * @return Brewery
     */
    public function addLocation(Brewery\Location $location): Brewery
    {
        if (!$this->hasLocation($location)) {
            $this->locations->add($location);
            $location->setBrewery($this);
        }

        return $this;
    }

    /**
     * @param Brewery\Url $url
     *
     * @return Brewery
     */
    public function addUrl(Brewery\Url $url): Brewery
    {
        if (!$this->hasUrl($url)) {
            $this->urls->add($url);
            $url->setBrewery($this);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getBreweryDBId(): string
    {
        return $this->brewerydbId;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return integer|null
     */
    public function getEstablished(): ?int
    {
        return $this->established;
    }

    /**
     * Return the Brewery\Url object for the Facebook type.
     *
     * @return Brewery\Url|null
     */
    public function getFacebookUrl(): ?Brewery\Url
    {
        return $this->getUrlType(Brewery\Url::TYPE_FACEBOOK);
    }

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Brewery\Url[]|Collection
     */
    public function getUrls(): Collection
    {
        return $this->urls;
    }

    /**
     * Return the Brewery\Url object for the Instagram type.
     *
     * @return Brewery\Url|null
     */
    public function getInstagramUrl(): ?Brewery\Url
    {
        return $this->getUrlType(Brewery\Url::TYPE_INSTAGRAM);
    }

    /**
     * Return the Brewery\Url object for the mailing list type.
     *
     * @return Brewery\Url|null
     */
    public function getMailingListUrl(): ?Brewery\Url
    {
        return $this->getUrlType(Brewery\Url::TYPE_MAILING_LIST);
    }

    /**
     * Return the Brewery\Url object for the Twitter type.
     *
     * @return Brewery\Url|null
     */
    public function getTwitterUrl(): ?Brewery\Url
    {
        return $this->getUrlType(Brewery\Url::TYPE_TWITTER);
    }

    /**
     * Return the Brewery\Url object for the Website type.
     *
     * @return Brewery\Url|null
     */
    public function getWebsiteUrl(): ?Brewery\Url
    {
        return $this->getUrlType(Brewery\Url::TYPE_WEBSITE);
    }

    /**
     * Return true/false if the Brewery object has a Facebook URL.
     *
     * @return bool
     */
    public function hasFacebookUrl(): bool
    {
        return $this->hasUrlType(Brewery\Url::TYPE_FACEBOOK);
    }

    /**
     * Return true/false if the Brewery object has a Instagram URL.
     *
     * @return bool
     */
    public function hasInstagramUrl(): bool
    {
        return $this->hasUrlType(Brewery\Url::TYPE_INSTAGRAM);
    }

    /**
     * Return true/false if this Brewery object has the Brewery\Location object.
     *
     * @param Brewery\Location $location
     *
     * @return bool
     */
    public function hasLocation(Brewery\Location $location): bool
    {
        return $this->urls->exists(function($idx, Brewery\Location $_location) use ($location) {
            return $location->getLatitude() === $_location->getLongitude()
                && strcasecmp($location->getLabel(), $_location->getLabel()) === 0;
        });
    }

    /**
     * Return true/false if the Brewery object has a Twitter URL.
     *
     * @return bool
     */
    public function hasTwitterUrl(): bool
    {
        return $this->hasUrlType(Brewery\Url::TYPE_TWITTER);
    }

    /**
     * Return true/false if the Brewery object has a Website URL.
     *
     * @return bool
     */
    public function hasWebsiteUrl(): bool
    {
        return $this->hasUrlType(Brewery\Url::TYPE_WEBSITE);
    }

    /**
     * Return true/false if this Brewery object has the Brewery\Url object.
     *
     * @param Brewery\Url $url
     *
     * @return bool
     */
    public function hasUrl(Brewery\Url $url): bool
    {
        return $this->urls->exists(function($idx, Brewery\Url $_url) use ($url) {
            return strcasecmp($url->getType(), $_url->getType()) === 0
                && strcasecmp($url->getUrl(), $_url->getType()) === 0;
        });
    }

    /**
     * @param bool|null $organic
     *
     * @return bool|$this
     */
    public function isOrganic(?bool $organic = null)
    {
        if ($organic !== null) {
            $this->organic = $organic;
            return $this;
        }

        return $this->organic;
    }

    /**
     * Remove the Brewery\Location object from the collection.
     *
     * @param Brewery\Location $location
     *
     * @return $this
     */
    public function removeLocation(Brewery\Location $location): self
    {
        if ($this->hasLocation($location)) {
            $this->locations->removeElement($location);
            $location->setBrewery(null);
        }

        return $this;
    }

    /**
     * Remove the Brewery\Url object from the collection.
     *
     * @param Brewery\Url $url
     *
     * @return $this
     */
    public function removeUrl(Brewery\Url $url): self
    {
        if ($this->hasUrl($url)) {
            $this->urls->removeElement($url);
            $url->setBrewery(null);
        }

        return $this;
    }

    /**
     * @param string $brewerydbId
     *
     * @return $this
     */
    public function setBreweryDBId(string $brewerydbId): self
    {
        $this->brewerydbId = $brewerydbId;

        return $this;
    }

    /**
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription(?string $description = null): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param int|null $established
     *
     * @return $this
     */
    public function setEstablished(?int $established = null): self
    {
        $this->established = $established;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Return the Brewery\Url object or null for the given type.
     *
     * @param string $type
     *
     * @return Brewery\Url|null
     */
    protected function getUrlType(string $type): ?Brewery\Url
    {
        return $this->hasUrlType($type)
            ? $this->getUrls()
                ->filter(function (Brewery\Url $url) use ($type) {
                    return strcasecmp($type, $url->getType()) === 0;
                })
                ->first()
            : null;
    }

    /**
     * Return true/false if the Brewery object has a Brewery\Url reference of the given type.
     *
     * @param string $type
     *
     * @return bool
     */
    protected function hasUrlType(string $type): bool
    {
        return $this->getUrls()
            ->exists(function ($idx, Brewery\Url $url) use ($type) {
                return strcasecmp($type, $url->getType()) === 0;
            });
    }
}
