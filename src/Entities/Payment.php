<?php

namespace Entities;

/**
 * Payment entity that will be returned by this system
 *
 * @package Entities
 */
class Payment
{
    private $_amount;
    private $_paymentNo;
    private $_description;
    private $_referenceNo;
    private $_payerName;

    /**
     * @var Invoice
     */
    private $_relatedInvoice;

    /**
     * Payment constructor.
     *
     * @param string $amount Amount paid with the payment
     * @param string $paymentNo Unique bank payment number
     * @param string $description Value from payment description
     * @param string $payerName Payer name
     * @param string $referenceNo Payment reference number, if exists. Default empty string
     */
    public function __construct($amount, $paymentNo, $description, $payerName, $referenceNo = '')
    {
        $this->_amount = $amount;
        $this->_paymentNo = $paymentNo;
        $this->_description = $description;
        $this->_payerName = $payerName;
        $this->_referenceNo = $referenceNo;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getPaymentNo()
    {
        return $this->_paymentNo;
    }

    /**
     * @param mixed $paymentNo
     */
    public function setPaymentNo($paymentNo)
    {
        $this->_paymentNo = $paymentNo;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
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
     * Set reference number
     *
     * @param $referenceNo
     */
    public function serReferenceNo($referenceNo)
    {
        $this->_referenceNo = $referenceNo;
    }

    /**
     * @return mixed
     */
    public function getPayerName()
    {
        return $this->_payerName;
    }

    /**
     * @param mixed $payer
     */
    public function setPayerName($payer)
    {
        $this->_payerName = $payer;
    }

    /**
     * @return Invoice
     */
    public function getRelatedInvoice()
    {
        return $this->_relatedInvoice;
    }

    /**
     * @param Invoice $relatedInvoice
     */
    public function setRelatedInvoice(Invoice $relatedInvoice)
    {
        $this->_relatedInvoice = $relatedInvoice;
    }


}