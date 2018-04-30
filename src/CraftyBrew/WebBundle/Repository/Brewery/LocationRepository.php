<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Repository\Brewery;

use CraftyBrew\WebBundle\Entity\Brewery;
use CraftyBrew\WebBundle\Entity\Brewery\Location;
use CraftyBrew\WebBundle\Entity\Brewery\Url;
use Doctrine\ORM\EntityRepository;

/**
 */
class LocationRepository extends EntityRepository
{
    /**
     * Return all of the brewery records.
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('bl')
            ->join(Brewery::class, 'b', 'WITH', 'b = bl.brewery')
            ->addOrderBy('bl.state', 'ASC')
            ->addOrderBy('bl.city', 'ASC')
            ->addOrderBy('b.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
