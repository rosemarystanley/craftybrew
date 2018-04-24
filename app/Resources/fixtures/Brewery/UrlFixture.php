<?php

declare(strict_types=1);

namespace CraftyBrew\DataFixtures\Brewery;

use CraftyBrew\DataFixtures\BreweryFixture;
use CraftyBrew\WebBundle\Entity\Brewery;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 */
class UrlFixture extends Fixture implements DependentFixtureInterface
{
    const CSV           = __DIR__ . '/../../breweries.csv';

    const CSV_NAME      = 0;
    const CSV_WEBSITE   = 7;
    const CSV_FACEBOOK  = 8;
    const CSV_TWITTER   = 9;
    const CSV_INSTAGRAM = 10;

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
            /** @var Brewery $brewery */
            $brewery = $this->getReference(trim($row[$this::CSV_NAME]));

            if (!$brewery) {
                throw new \UnexpectedValueException(sprintf('Unable to locate an entity named %s', $row[$this::CSV_NAME]));
            }

            if (isset($row[$this::CSV_FACEBOOK]) && !empty(trim($row[$this::CSV_FACEBOOK]))) {
                $brewery->addUrl(
                    (new Brewery\Url)
                        ->setType(Brewery\Url::TYPE_FACEBOOK)
                        ->setUrl(trim($row[$this::CSV_FACEBOOK]))
                );

                $manager->persist($brewery);
            }

            if (isset($row[$this::CSV_INSTAGRAM]) && !empty(trim($row[$this::CSV_INSTAGRAM]))) {
                $brewery->addUrl(
                    (new Brewery\Url)
                        ->setType(Brewery\Url::TYPE_INSTAGRAM)
                        ->setUrl(trim($row[$this::CSV_INSTAGRAM]))
                );

                $manager->persist($brewery);
            }

            if (isset($row[$this::CSV_TWITTER]) && !empty(trim($row[$this::CSV_TWITTER]))) {
                $brewery->addUrl(
                    (new Brewery\Url)
                        ->setType(Brewery\Url::TYPE_TWITTER)
                        ->setUrl(trim($row[$this::CSV_TWITTER]))
                );

                $manager->persist($brewery);
            }

            if (isset($row[$this::CSV_WEBSITE]) && !empty(trim($row[$this::CSV_TWITTER]))) {
                $brewery->addUrl(
                    (new Brewery\Url)
                        ->setType(Brewery\Url::TYPE_WEBSITE)
                        ->setUrl(trim($row[$this::CSV_WEBSITE]))
                );

                $manager->persist($brewery);
            }

            unset($brewery, $row);
        }

        fclose($fhandle);
        $manager->flush();
    }

    /**
     * @return array
     */
    function getDependencies()
    {
        return [
            BreweryFixture::class
        ];
    }
}
