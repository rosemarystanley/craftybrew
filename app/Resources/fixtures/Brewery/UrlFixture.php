<?php

declare(strict_types=1);

namespace CraftyBrew\DataFixtures\Brewery;

use CraftyBrew\DataFixtures\AbstractFixture;
use CraftyBrew\DataFixtures\BreweryFixture;
use CraftyBrew\WebBundle\Entity\Brewery;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 */
class UrlFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @return array
     */
    function getDependencies()
    {
        return [
            BreweryFixture::class,
            LocationFixture::class,
        ];
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
    }
}
