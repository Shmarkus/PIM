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
                    $result->append(new Payment($amount, $paymentNo, $invoice, ''));
                }
            }
        } else {
            throw new \Exception('Unable to parse XML stream');
        }
        return $result;
    }
}