<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Repository;

use CraftyBrew\WebBundle\Entity\Brewery;
use Doctrine\ORM\EntityRepository;

/**
 */
class BreweryRepository extends EntityRepository
{
    /**
     * Return all of the brewery records.
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('b, bu', 'b.id')
            ->from(Brewery::class, 'b')
            ->leftJoin(Brewery\Url::class, 'bu')
            ->addOrderBy('b.state', 'ASC')
            ->addOrderBy('b.city', 'ASC')
            ->addOrderBy('b.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
