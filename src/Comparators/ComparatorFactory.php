<?php

namespace Comparators;

/**
 * Interface describes comparator factory method
 *
 * @package Comparators
 */
interface ComparatorFactory
{
    /**
     * Determine correct comparator by name and retrieve the instance to it
     *
     * @param string $name Name of the comparator
     *
     * @return Comparator
     * @throws \Exception When called comparator name is not registered, exception is thrown
     */
    public function getComparator($name);
}