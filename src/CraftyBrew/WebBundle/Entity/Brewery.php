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
    /**
     * @ORM\Column(name="address", type="string", length=255)
     * @Annotation\Groups({"list"})
     *
     * @var string
     */
    private $address;

    /**
     * @ORM\Column(name="city", type="string", length=100)
     * @Annotation\Groups({"list"})
     *
     * @var string
     */
    private $city;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     * @Annotation\Groups({"list"})
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="latitude", type="decimal", scale=6, precision=8)
     * @Annotation\Groups({"list"})
     *
     * @var float
     */
    private $latitude;

    /**
     * @ORM\Column(name="longitude", type="decimal", scale=6, precision=8)
     * @Annotation\Groups({"list"})
     *
     * @var float
     */
    private $longitude;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @Annotation\Groups({"list"})
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="state", type="string", length=2)
     * @Annotation\Groups({"list"})
     *
     * @var string
     */
    private $state;

    /**
     * @ORM\Column(name="postal", type="string", length=15)
     * @Annotation\Groups({"list"})
     *
     * @var string
     */
    private $postal;

    /**
     * @ORM\OneToMany(targetEntity="CraftyBrew\WebBundle\Entity\Brewery\Url", mappedBy="brewery", cascade={"persist","remove"})
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
    }

    /**
     * @param Brewery\Url $url
     *
     * @return Brewery
     */
    public function addUrl(Brewery\Url $url)
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Return the Brewery\Url object for the Facebook type.
     *
     * @return Brewery\Url|null
     */
    public function getFacebookUrl()
    {
        return $this->getUrlType(Brewery\Url::TYPE_FACEBOOK);
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getPostal()
    {
        return $this->postal;
    }

    /**
     * @return Brewery\Url[]|Collection
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * Return the Brewery\Url object for the Instagram type.
     *
     * @return Brewery\Url|null
     */
    public function getInstagramUrl()
    {
        return $this->getUrlType(Brewery\Url::TYPE_INSTAGRAM);
    }

    /**
     * Return the Brewery\Url object for the Twitter type.
     *
     * @return Brewery\Url|null
     */
    public function getTwitterUrl()
    {
        return $this->getUrlType(Brewery\Url::TYPE_TWITTER);
    }

    /**
     * Return the Brewery\Url object for the Website type.
     *
     * @return Brewery\Url|null
     */
    public function getWebsiteUrl()
    {
        return $this->getUrlType(Brewery\Url::TYPE_WEBSITE);
    }

    /**
     * Return true/false if the Brewery object has a Facebook URL.
     *
     * @return bool
     */
    public function hasFacebookUrl()
    {
        return $this->hasUrlType(Brewery\Url::TYPE_FACEBOOK);
    }

    /**
     * Return true/false if the Brewery object has a Instagram URL.
     *
     * @return bool
     */
    public function hasInstagramUrl()
    {
        return $this->hasUrlType(Brewery\Url::TYPE_INSTAGRAM);
    }

    /**
     * Return true/false if the Brewery object has a Twitter URL.
     *
     * @return bool
     */
    public function hasTwitterUrl()
    {
        return $this->hasUrlType(Brewery\Url::TYPE_TWITTER);
    }

    /**
     * Return true/false if the Brewery object has a Website URL.
     *
     * @return bool
     */
    public function hasWebsiteUrl()
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
    public function hasUrl(Brewery\Url $url)
    {
        return $this->urls->exists(function($idx, Brewery\Url $_url) use ($url) {
            return strcasecmp($url->getType(), $_url->getType()) === 0
                && strcasecmp($url->getUrl(), $_url->getType()) === 0;
        });
    }

    /**
     * Remove the Brewery\Url object from the collection.
     *
     * @param Brewery\Url $url
     *
     * @return $this
     */
    public function removeUrl(Brewery\Url $url)
    {
        if ($this->hasUrl($url)) {
            $this->urls->removeElement($url);
            $url->setBrewery(null);
        }

        return $this;
    }

    /**
     * @param string $address
     *
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @param string $city
     *
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param float $latitude
     *
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @param float $longitude
     *
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @param string $postal
     *
     * @return $this
     */
    public function setPostal($postal)
    {
        $this->postal = $postal;

        return $this;
    }

    /**
     * Return the Brewery\Url object or null for the given type.
     *
     * @param string $type
     *
     * @return Brewery\Url|null
     */
    protected function getUrlType($type)
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
    protected function hasUrlType($type)
    {
        return $this->getUrls()
            ->exists(function ($idx, Brewery\Url $url) use ($type) {
                return strcasecmp($type, $url->getType()) === 0;
            });
    }
}
