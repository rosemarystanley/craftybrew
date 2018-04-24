<?php

declare(strict_types=1);

namespace CraftyBrew\DataFixtures;

use CraftyBrew\WebBundle\Entity\Brewery;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BreweryFixture extends Fixture
{
    const CSV           = __DIR__ . '/../breweries.csv';

    const CSV_NAME      = 0;
    const CSV_ADDRESS   = 1;
    const CSV_CITY      = 2;
    const CSV_STATE     = 3;
    const CSV_POSTAL    = 4;
    const CSV_LATITUDE  = 5;
    const CSV_LONGITUDE = 6;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $fhandle = fopen($this::CSV, 'r', false);

        if (!is_resource($fhandle)) {
            throw new \UnexpectedValueException(sprintf('Unable to open %s for reading', $this::CSV));
        }

        // Remove the headers
        fgetcsv($fhandle);

        while (($row = fgetcsv($fhandle)) !== false) {
            $brewery = new Brewery;
            $brewery
                ->setAddress(trim($row[$this::CSV_ADDRESS]))
                ->setCity(trim($row[$this::CSV_CITY]))
                ->setLatitude(number_format((float)trim($row[$this::CSV_LATITUDE]), 6))
                ->setLongitude(number_format((float)trim($row[$this::CSV_LONGITUDE]), 6))
                ->setName(trim($row[$this::CSV_NAME]))
                ->setPostal(trim($row[$this::CSV_POSTAL]))
                ->setState(trim($row[$this::CSV_STATE]));

            $manager->persist($brewery);

            $this->setReference($brewery->getName(), $brewery);

            unset($brewery, $row);
        }

        fclose($fhandle);
        $manager->flush();
    }
}
