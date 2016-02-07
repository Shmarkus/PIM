<?php

namespace Mappers;

use Entities\Invoice;
use Extractors\FileExtractor;

/**
 * Implementation of mapper. Use this to map invoices with payments
 *
 * @package Mappers
 */
class MapperImpl implements Mapper
{

    /**
     * Apache Log4PHP logger object
     *
     * @var \Logger
     */
    private $_logger;

    /**
     * AbstractParser constructor.
     */
    public function __construct()
    {
        $this->_logger = new \Logger(get_class($this));
    }

    /**
     * Map $invoices with Payments that are retrieved from $pathToFile using $parserName parser
     *
     * @param \ArrayObject $invoices Invoices to check
     * @param string $pathToSource Absolute path source, that contains payments
     * @param string $parserName Name of the parser to use while parsing file (see ParserFactory class)
     *
     * @return \ArrayObject List of invoices that were paid
     * @throws \Exception When file parsing fails, exception is thrown
     */
    public function map(\ArrayObject $invoices, $pathToSource, $parserName)
    {
        $results = new \ArrayObject();
        $extractor = new FileExtractor();
        $extractor->extractPayments($pathToSource, $parserName);
        $payments = $extractor->getPayments();
        foreach ($payments as $payment) {
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
                        $results->append($payment);
                    }
                } else {
                    throw new \Exception("Invoice not implementing correct interface!");
                }

            }
        }
        return $results;
    }
}