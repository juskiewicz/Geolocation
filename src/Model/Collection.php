<?php

namespace Geocoder;
use Geocoder\Exception\CollectionIsEmpty;
use Geocoder\Exception\OutOfBounds;
/**
 * This is the interface that is always return from a Geocoder.
 *
 * @author William Durand <william.durand1@gmail.com>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
interface Collection extends \IteratorAggregate, \Countable
{
    /**
     * @return Address
     *
     * @throws CollectionIsEmpty
     */
    public function first(): Location;
    /**
     * @return bool
     */
    public function isEmpty(): bool;
    /**
     * @return Location[]
     */
    public function slice(int $offset, int $length = null);
    /**
     * @return bool
     */
    public function has(int $index): bool;
    /**
     * @return Location
     *
     * @throws OutOfBounds
     */
    public function get(int $index): Location;
    /**
     * @return Location[]
     */
    public function all(): array;
}