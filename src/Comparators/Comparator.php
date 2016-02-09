<?php

namespace Comparators;

/**
 * Comparator interface describes methods for a comparator class. Comparator methods use special algorithms to compare
 * Invoices and Payments
 *
 * @package Comparators
 */
interface Comparator
{
    /**
     * Using specified comparison logic, compare invoices with payments and return the payments that match the invoices
     *
     * @param \ArrayObject $invoices Invoices to compare against
     * @param \ArrayObject $payments Payments to compare with
     *
     * @return \ArrayObject Mapped payments that represented an Invoice
     * @throws \Exception When comparison fails due to incompatible data types etc.
     */
    public function compare(\ArrayObject $invoices, \ArrayObject $payments);
}