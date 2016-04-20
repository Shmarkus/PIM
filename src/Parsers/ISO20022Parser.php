<?php

namespace Parsers;

use Entities\Payment;

/**
 * Parser for ISO20022 document
 *
 * @package Parsers
 */
class ISO20022Parser extends AbstractParser implements Parser
{
    /**
     * Your invoice number regular expression pattern. This is meant to match invoices such as 1234/ABCDE
     *
     * @var string
     */
    private $_pattern = '/[0-9]+.[a-zA-Z]+/';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Parse XML stream that is in ISO20022 format
     *
     * @param $stream
     * @return \ArrayObject
     *
     * @throws \Exception
     */
    public function parseData($stream)
    {
        $result = new \ArrayObject();

        if ($xml = simplexml_load_string($stream)) {
            $rpt = $xml->BkToCstmrAcctRpt->Rpt;
            foreach ($rpt->children() as $element) {
                if ($element->getName() == 'Ntry') {
                    $amount = $element->Amt->__toString();
                    $paymentNo = $element->NtryRef->__toString();
                    $invoice = $element->NtryDtls->TxDtls->RmtInf->Ustrd->__toString();
                    preg_match_all($this->_pattern, $invoice, $matches);
                    $payer = $element->NtryDtls->TxDtls->RltdPties->Dbtr->Nm;
                    //multiple invoices paid
                    if (count($matches[0]) > 0) {
                        foreach ($matches[0] as $match) {
                            $result->append(new Payment($amount, $paymentNo, $match, $payer));
                        }
                    }
                }
            }
        } else {
            throw new \Exception('Unable to parse XML stream');
        }
        return $result;
    }
}