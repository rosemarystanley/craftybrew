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
 * @ORM\Table(name="brewery_url", indexes={
 *     @ORM\Index(name="idx_brewery_url_brewery_id", columns={"brewery_id"}),
 *     @ORM\Index(name="idx_brewery_url_type", columns={"type"})
 * })
 */
class Url extends AbstractEntity
{
    use EntityDateTrackingTrait;

    const TYPE_FACEBOOK     = 'facebook';
    const TYPE_INSTAGRAM    = 'instagram';
    const TYPE_MAILING_LIST = 'mailing-list';
    const TYPE_TWITTER      = 'twitter';
    const TYPE_WEBSITE      = 'website';

    /**
     * @ORM\ManyToOne(targetEntity="CraftyBrew\WebBundle\Entity\Brewery", inversedBy="urls")
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
     * @Serializer\Groups({"list"})
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="type", type="string", length=15)
     * @Serializer\Groups({"list"})
     *
     * @var string
     */
    private $type;

    /**
     * @ORM\Column(name="url", type="string", length=255)
     * @Serializer\Groups({"list"})
     *
     * @var string
     */
    private $url;

    /**
     * Initialize the Brewery object.
     */
    public function __construct()
    {
        $this->dateCreated = new \DateTimeImmutable;
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
    public function getBreweryDBId(): string
    {
        return $this->brewerydbId;
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Return true/false if the Url type is for facebook.
     *
     * @return bool
     */
    public function isFacebook(): bool
    {
        return $this->type === $this::TYPE_FACEBOOK;
    }

    /**
     * Return true/false if the Url type is for Instagram.
     *
     * @return bool
     */
    public function isInstagram(): bool
    {
        return $this->type === $this::TYPE_INSTAGRAM;
    }

    /**
     * Return true/false if the Url type is for a mailing list.
     *
     * @return bool
     */
    public function isMailingList(): bool
    {
        return $this->type === $this::TYPE_MAILING_LIST;
    }

    /**
     * Return true/false if the Url type is for Twitter.
     *
     * @return bool
     */
    public function isTwitter(): bool
    {
        return $this->type === $this::TYPE_TWITTER;
    }

    /**
     * Return true/false if the Url type is for a website.
     *
     * @return bool
     */
    public function isWebsite(): bool
    {
        return $this->type === $this::TYPE_WEBSITE;
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
    public function setBreweryDBId(string $brewerydbId): self
    {
        $this->brewerydbId = $brewerydbId;

        return $this;
    }

    /**
     * @param integer $id
     *
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

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

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
