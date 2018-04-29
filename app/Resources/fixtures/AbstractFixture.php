<?php

declare(strict_types=1);

namespace CraftyBrew\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 */
abstract class AbstractFixture extends Fixture
{
    /**
     * Return a \FilterIterator of the files in $directory that match the optional $regexp.
     *
     * @param string $directory
     * @param string|null $regexp
     *
     * @return \Iterator
     */
    public function getDirectoryIterator($directory, $regexp = null)
    {
        $rdi = new \RecursiveDirectoryIterator(
            $directory,
            \FilesystemIterator::NEW_CURRENT_AND_KEY | \FilesystemIterator::SKIP_DOTS
        );

        if (!$regexp) {
            $regexp = '/^.+$/';
        }

        return (new \RegexIterator(
            new \RecursiveIteratorIterator($rdi),
            $regexp,
            \RecursiveRegexIterator::GET_MATCH
        ))->getInnerIterator();
    }
}
