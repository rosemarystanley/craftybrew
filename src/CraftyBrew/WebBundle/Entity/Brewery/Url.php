<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Entity\Brewery;

use CraftyBrew\WebBundle\Entity\AbstractEntity;
use CraftyBrew\WebBundle\Entity\Brewery;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="brewery_url", indexes={
 *     @ORM\Index(name="idx_brewery_url_brewery_id", columns={"brewery_id"}),
 *     @ORM\Index(name="idx_brewery_url_type", columns={"type"})
 * })
 */
class Url extends AbstractEntity
{
    const TYPE_FACEBOOK     = 'facebook';
    const TYPE_INSTAGRAM    = 'instagram';
    const TYPE_TWITTER      = 'twitter';
    const TYPE_WEBSITE      = 'website';

    /**
     * @ORM\ManyToOne(targetEntity="CraftyBrew\WebBundle\Entity\Brewery", inversedBy="urls")
     * @ORM\JoinColumn(name="brewery_id", referencedColumnName="id")
     *
     * @var Brewery
     */
    private $brewery;

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
     * @ORM\Column(name="type", type="string", length=15)
     * @Annotation\Groups({"list"})
     *
     * @var string
     */
    private $type;

    /**
     * @ORM\Column(name="url", type="string", length=255)
     * @Annotation\Groups({"list"})
     *
     * @var string
     */
    private $url;

    /**
     * @return Brewery
     */
    public function getBrewery()
    {
        return $this->brewery;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Return true/false if the Url type is for facebook.
     *
     * @return bool
     */
    public function isFacebook()
    {
        return $this->type === $this::TYPE_FACEBOOK;
    }

    /**
     * Return true/false if the Url type is for Instagram.
     *
     * @return bool
     */
    public function isInstagram()
    {
        return $this->type === $this::TYPE_INSTAGRAM;
    }

    /**
     * Return true/false if the Url type is for Twitter.
     *
     * @return bool
     */
    public function isTwitter()
    {
        return $this->type === $this::TYPE_TWITTER;
    }

    /**
     * Return true/false if the Url type is for a website.
     *
     * @return bool
     */
    public function isWebsite()
    {
        return $this->type === $this::TYPE_WEBSITE;
    }

    /**
     * @param Brewery|null $brewery
     *
     * @return $this
     */
    public function setBrewery(Brewery $brewery = null)
    {
        $this->brewery = $brewery;

        return $this;
    }

    /**
     * @param integer $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
