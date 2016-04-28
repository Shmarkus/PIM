<?php

namespace Parsers;

/**
 * Parser for ISO20022-53 document
 *
 * @package Parsers
 */
class ISO2002253Parser extends ISO20022Parser implements Parser
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getElement($xml)
    {
        return $xml->BkToCstmrStmt->Stmt;
    }
}