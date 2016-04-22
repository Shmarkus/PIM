<?php

namespace Parsers;

use Entities\Payment;

/**
 * Parser for Nordea TeleHansa format documents
 *
 * @package Parsers
 */
class NordeaTHParser extends AbstractParser implements Parser
{
    /**
     * NordeaTHParser constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Parse stream and return array object of parsed payments
     *
     * @param string $stream Stream of data to parse to payments
     * @return \ArrayObject
     * @throws \Exception when format is unrecognized
     */
    public function parseData($stream)
    {
        $result = new \ArrayObject();
        $rows = explode("\n", $stream);
        foreach (array_filter($rows) as $row) {
            if (substr($row, 4, 3) != '999' && substr($row, 4, 1) == '1') {
                $amount = (int)substr($row, 199, 10) . ',' . substr($row, 209, 2);
                $paymentNo = substr($row, 11, 10);
                $description = trim(substr($row, 122, 75));
                $payerName = trim(substr($row, 77, 30));
                $referenceNo = "";//TODO: in what location is reference no?
                //multiple invoices paid
                if ($matches = $this->_getMatches($description)) {
                    foreach ($matches as $match) {
                        $result->append(new Payment($amount, $paymentNo, $match, $payerName, $referenceNo));
                    }
                }
            }
        }
        return $result;
    }
}