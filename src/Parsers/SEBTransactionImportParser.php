<?php

namespace Parsers;

use Entities\Payment;

/**
 * Parser for SEB transaction import file format documents
 * @see http://www.seb.ee/files/juhendid/Importfailide_kirjeldus.pdf
 *
 * @package Parsers
 */
class SEBTransactionImportParser extends AbstractParser implements Parser
{
    /**
     * SEBTransactionImportParser constructor.
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
        $amountPadding = 6;
        $paymentNoPadding = 2;
        $descriptionPadding = 9;
        $payerNamePadding = 7;

        $result = new \ArrayObject();
        $rows = explode("\n", $stream);
        $trimmedRows = $rows;
        for ($i = 0; $i < count($trimmedRows); $i++) {
            if ($trimmedRows[$i] == '#7') {
                $amount = (int)substr($trimmedRows[$i + $amountPadding], 0, 11) . ',' . substr($trimmedRows[$i + $amountPadding], 11, 2);
                $paymentNo = trim($trimmedRows[$i + $paymentNoPadding]);
                $description = trim($trimmedRows[$i + $descriptionPadding]);
                $payerName = trim($trimmedRows[$i + $payerNamePadding]);
                $referenceNo = "";//TODO: in what location is reference no?
                //multiple invoices paid
                if ($matches = $this->_getMatches($description)) {
                    foreach ($matches as $match) {
                        $result->append(new Payment($amount, $paymentNo, $match, $payerName, $referenceNo));
                    }
                }
                //skip the entry
                $i = $i + $trimmedRows[$i + 1];
            }
        }
        return $result;
    }
}