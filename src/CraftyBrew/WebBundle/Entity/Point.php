<?php

declare(strict_types=1);

namespace CraftyBrew\WebBundle\Entity;

/**
 * This is a helper entity for whenever we need to handle coordinate systems.
 */
class Point
{
    /**
     * @var integer|float
     */
    private $x;

    /**
     * @var integer|float
     */
    private $y;

    /**
     * Point constructor.
     *
     * @param integer|float $x
     * @param integer|float $y
     *
     * @return void
     */
    public function __construct($x, $y)
    {
        $this->x = is_numeric($x) && strpos((string)$x, '.') >= 0
            ? (float)$x
            : (int)$x;

        $this->y = is_numeric($y) && strpos((string)$y, '.') >= 0
            ? (float)$y
            : (int)$y;
    }

    /**
     * Return the value of the point for x or y.
     *
     * @param $name
     *
     * @return integer|float
     */
    public function __get(string $name)
    {
        if ($name !== 'x' && $name !== 'y') {
            throw new \UnexpectedValueException(sprintf('Expected coordinate of either x or y, but got %s', $name));
        }

        return $this->{$name};
    }
}
