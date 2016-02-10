<?php

namespace Comparators;

use Entities\Invoice;
use Entities\Payment;

class InvoicePaymentReferenceNoComparator implements Comparator
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
    public function compare(\ArrayObject $invoices, \ArrayObject $payments)
    {
        $results = new \ArrayObject();
        foreach ($payments as $payment) {
            if ($payment instanceof Payment) {
                foreach ($invoices as $invoice) {
                    if ($invoice instanceof Invoice) {
                        $invoiceNoMatch = false;
                        if ($invoice->getInvoiceNo() != '') {
                            $invoiceNoMatch = strpos($payment->getDescription(), $invoice->getInvoiceNo()) !== false;
                        }
                        $orderNoMatch = false;
                        if ($invoice->getOrderNo() != '') {
                            $orderNoMatch = strpos($payment->getDescription(), $invoice->getOrderNo()) !== false;
                        }
                        if (($payment->getReferenceNo() == $invoice->getReferenceNo() && $payment->getReferenceNo() != '')
                            || ($orderNoMatch || $invoiceNoMatch)
                        ) {
                            $payment->setRelatedInvoice($invoice);
                            $results->append($payment);
                        }
                    } else {
                        throw new \Exception("Invoice not implementing correct interface!");
                    }

                }
            } else {
                throw new \Exception("Payment data type is incorrect!");
            }
        }
        return $results;
    }
}