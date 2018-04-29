<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Entity;

/**
 * Trait for entities to use for created/updated time tracking.
 */
trait EntityDateTrackingTrait
{
    /**
     * @ORM\Column(name="date_created", type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"})
     *
     * @var \DateTimeImmutable
     */
    private $dateCreated;

    /**
     * @ORM\Column(name="date_updated", type="datetime_immutable", columnDefinition="DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '(DC2Type:datetime_immutable)'")
     *
     * @var \DateTimeImmutable
     */
    private $dateUpdated;

    /**
     * Return the created date.
     *
     * @return \DateTimeImmutable
     */
    public function getDateCreated(): \DateTimeImmutable
    {
        return $this->dateCreated;
    }

    /**
     * Return the updated date, or null.
     *
     * @return \DateTimeImmutable|null
     */
    public function getDateUpdated(): ?\DateTimeImmutable
    {
        return $this->dateUpdated;
    }
}
