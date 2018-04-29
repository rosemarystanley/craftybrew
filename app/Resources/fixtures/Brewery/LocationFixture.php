<?php

declare(strict_types=1);

namespace CraftyBrew\DataFixtures\Brewery;

use CraftyBrew\DataFixtures\AbstractFixture;
use CraftyBrew\DataFixtures\BreweryFixture;
use CraftyBrew\WebBundle\Entity\Brewery;
use CraftyBrew\WebBundle\Entity\Brewery\Location;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 */
class LocationFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getDependencies()
    {
        return [
            BreweryFixture::class
        ];
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $iterator = $this->getDirectoryIterator(__DIR__ . '/../../seeds', '/\.json$/i');

        /** @var \SplFileInfo $fileInfo */
        foreach ($iterator as $fileInfo) {
            $locations = $this->parse($fileInfo->getRealPath());

            /** @var Location $location*/
            foreach ($locations as $location) {
                if (!$this->hasReference($location->getBreweryDBId())) {
                    $this->setReference($location->getBreweryDBId(), $location);
                    $manager->persist($location);
                }
            }
        }

        $manager->flush();
    }

    /**
     * Parse the JSON file and return an array of Brewery objects.
     *
     * @param string $file
     *
     * @return Location[]
     */
    protected function parse(string $file): array
    {
        if (!is_readable($file)) {
            throw new \DomainException(sprintf('Unable to read the file %s', $file));
        }

        $data = json_decode(file_get_contents($file));

        $locations = [];

        foreach ($data->data as $location) {
            $location = (array)$location;

            $address = array_key_exists('streetAddress', $location)
                ? $location['streetAddress']
                : null;
            $extendedAddress = array_key_exists('extendedAddress', $location)
                ? $location['extendedAddress']
                : null;
            $hours = array_key_exists('hoursOfOperation', $location)
                ? $location['hoursOfOperation']
                : null;
            $opened = array_key_exists('yearOpened', $location)
                ? (int)$location['yearOpened']
                : null;
            $phone = array_key_exists('phone', $location)
                ? ltrim(preg_replace('/[^\d]+/', '', $location['phone']), '1')
                : null;
            $postal = array_key_exists('postalCode', $location)
                ? $location['postalCode']
                : null;

            /** @var Brewery $brewery */
            $brewery = $this->getReference($location['brewery']->id);

            $location = (new Location)
                ->setAddress($address)
                ->setAddressExtended($extendedAddress)
                ->setBrewerydbId($location['id'])
                ->setCity($location['locality'])
                ->setHours($hours)
                ->setLabel($location['name'])
                ->setLatitude($location['latitude'])
                ->setLongitude($location['longitude'])
                ->setOpened($opened)
                ->setPhone($phone)
                ->setPostal($postal)
                ->setState($location['region'])
                ->setType($location['locationType']);

            $brewery->addLocation($location);

            $locations[] = $location;
        }

        return $locations;
    }
}
