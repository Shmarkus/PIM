<?php

namespace Comparators;


class ComparatorFactoryImpl implements ComparatorFactory
{
    /**
     * Determine correct comparator by name and retrieve the instance to it
     *
     * @param string $name Name of the comparator
     *
     * @return Comparator
     * @throws \Exception When called comparator name is not registered, exception is thrown
     */
    public function getComparator($name)
    {
        switch ($name) {
            case 'IPRNo':
                return new InvoicePaymentReferenceNoComparator();
            default:
                throw new \Exception('Unknown comparator: ' . $name);
        }
    }
}