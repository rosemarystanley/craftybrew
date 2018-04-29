<?php

declare(strict_types=1);

namespace CraftyBrew\DataFixtures;

use CraftyBrew\WebBundle\Entity\Brewery;
use Doctrine\Common\Persistence\ObjectManager;

class BreweryFixture extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $iterator = $this->getDirectoryIterator(__DIR__ . '/../seeds', '/\.json$/i');

        /** @var \SplFileInfo $fileInfo */
        foreach ($iterator as $fileInfo) {
            $breweries = $this->parse($fileInfo->getRealPath());

            /** @var Brewery $brewery */
            foreach ($breweries as $brewery) {
                if (!$this->hasReference($brewery->getBreweryDBId())) {
                    $this->setReference($brewery->getBreweryDBId(), $brewery);
                    $manager->persist($brewery);
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
     * @return Brewery[]
     */
    protected function parse(string $file): array
    {
        if (!is_readable($file)) {
            throw new \DomainException(sprintf('Unable to read the file %s', $file));
        }

        $data = json_decode(file_get_contents($file));

        $breweries = [];

        foreach ($data->data as $location) {
            $brewery = (array)$location->brewery ?: [];

            $description = array_key_exists('description', $brewery)
                ? $brewery['description']
                : null;
            $established = array_key_exists('established', $brewery)
                ? (int)$brewery['established']
                : null;
            $organic = array_key_exists('isOrganic', $brewery)
                ? strcasecmp($brewery['isOrganic'], 'N') !== 0
                : false;

            $breweries[] = (new Brewery)
                ->isOrganic($organic)
                ->setBreweryDBId($brewery['id'])
                ->setDescription($description)
                ->setEstablished($established)
                ->setName($brewery['name']);
        }

        return $breweries;
    }
}
