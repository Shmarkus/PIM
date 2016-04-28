<?php

namespace Parsers;

/**
 * Parser for ISO20022-52 document
 *
 * @package Parsers
 */
class ISO2002252Parser extends ISO20022Parser implements Parser
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getElement($xml)
    {
        return $xml->BkToCstmrAcctRpt->Rpt;
    }
}