<?php

namespace Entities;

class SampleInvoice implements Invoice
{
    private $_amount;
    private $_invoiceNo;
    private $_orderNo;
    private $_referenceNo;

    /**
     * SampleInvoice constructor.
     *
     * @param $amount
     * @param $invoiceNo
     * @param $orderNo
     * @param $referenceNo
     */
    public function __construct($amount, $invoiceNo, $orderNo, $referenceNo)
    {
        $this->_amount = $amount;
        $this->_invoiceNo = $invoiceNo;
        $this->_orderNo = $orderNo;
        $this->_referenceNo = $referenceNo;
    }

    /**
     * Get the invoice number (this might not be set)
     *
     * @return string
     */
    public function getInvoiceNo()
    {
        return $this->_invoiceNo;
    }

    /**
     * Get the order number
     *
     * @return mixed
     */
    public function getOrderNo()
    {
        return $this->_orderNo;
    }

    /**
     * Newer orders have client reference number. This is used when present!
     *
     * @return mixed
     */
    public function getReferenceNo()
    {
        return $this->_referenceNo;
    }

    /**
     * Get the price from the invoice
     *
     * @return double
     */
    public function getAmount()
    {
        return $this->_amount;
    }
}