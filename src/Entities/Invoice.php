<?php

namespace Entities;

/**
 * Invoices passed to this system must implement the invoice interface!
 *
 * @package Entities
 */
interface Invoice
{
    /**
     * Get the invoice number (this might not be set)
     *
     * @return string
     */
    public function getInvoiceNo();

    /**
     * Get the order number
     *
     * @return mixed
     */
    public function getOrderNo();

    /**
     * Newer orders have client reference number. This is used when present!
     *
     * @return mixed
     */
    public function getReferenceNo();

    /**
     * Get the price from the invoice
     *
     * @return double
     */
    public function getAmount();
}