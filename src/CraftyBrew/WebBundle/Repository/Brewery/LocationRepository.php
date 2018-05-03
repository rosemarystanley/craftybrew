<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Repository\Brewery;

use CraftyBrew\WebBundle\Entity\Brewery;
use CraftyBrew\WebBundle\Entity\Point;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 */
class LocationRepository extends EntityRepository
{
    /**
     * Return all of the brewery records.
     *
     * @return Brewery\Location[]
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

    /**
     * Return all brewery records within $radius of $coords.
     *
     * @param Point $coords
     * @param integer|float $radius
     *
     * @return Brewery\Location[]
     */
    public function findByGeometry(Point $coords, $radius)
    {
        $rsmb = $this->createResultSetMappingBuilder('bl');

        $rsmb->addFieldResult('bl', 'id', 'id');
        $rsmb->addFieldResult('bl', 'address', 'address');
        $rsmb->addFieldResult('bl', 'address_extended', 'addressExtended');
        $rsmb->addFieldResult('bl', 'city', 'city');
        $rsmb->addFieldResult('bl', 'state', 'state');
        $rsmb->addFieldResult('bl', 'postal', 'postal');
        $rsmb->addFieldResult('bl', 'hours', 'hours');
        $rsmb->addFieldResult('bl', 'label', 'label');
        $rsmb->addFieldResult('bl', 'latitude', 'latitude');
        $rsmb->addFieldResult('bl', 'longitude', 'longitude');
        $rsmb->addFieldResult('bl', 'opened', 'opened');
        $rsmb->addFieldResult('bl', 'phone', 'phone');
        $rsmb->addFieldResult('bl', 'date_created', 'dateCreated');
        $rsmb->addFieldResult('bl', 'date_updated', 'dateUpdated');

        $rsmb->addJoinedEntityResult(Brewery::class, 'b', 'bl', 'brewery');
        $rsmb->addFieldResult('b', 'id', 'id');
        $rsmb->addFieldResult('b', 'name', 'name');
        $rsmb->addFieldResult('b', 'description', 'description');
        $rsmb->addFieldResult('b', 'date_created', 'dateCreated');
        $rsmb->addFieldResult('b', 'date_updated', 'dateUpdated');

        $query = $this->getEntityManager()->createNativeQuery('
            SELECT ' . $rsmb->generateSelectClause(['bl', 'b']) . '
            FROM brewery_location bl
            JOIN brewery b ON b.id = bl.brewery_id
            WHERE MBRContains(
                GeomFromText(
                    (
                        SELECT 
                            CONCAT(\'LINESTRING(\',
                                latitude-:radius, \' \', longitude-:radius,
                                \', \',
                                latitude+:radius, \' \', longitude+:radius,
                            \')\')
                        FROM (
                            SELECT :latitude AS latitude, :longitude AS longitude
                        ) as coords
                    )
                ),
                Point(latitude, longitude)
            )
            ORDER BY bl.state, bl.city, bl.postal, b.name
        ', $rsmb);
        $query->setParameter('latitude', $coords->x);
        $query->setParameter('longitude', $coords->y);
        $query->setParameter('radius', $radius);

        return $query->getResult();
    }
}
