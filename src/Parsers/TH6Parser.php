<?php

namespace Parsers;

use Entities\Payment;

/**
 * Parser for TH6 format documents
 *
 * @package Parsers
 */
class TH6Parser extends AbstractParser implements Parser
{
    /**
     * TH6Parser constructor.
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
            $item = explode(";", $row);
            if (count($item) > 11) {
                //multiple invoices paid
                if ($matches = $this->_getMatches($this->_stripQuotes($item[11]))) {
                    foreach ($matches as $match) {
                        $result->append(new Payment($this->_stripQuotes($item[8]), $this->_stripQuotes($item[10]), $match, $this->_stripQuotes($item[4])));
                    }
                }
            } else {
                throw new \Exception('File format unrecognized: ' . $row);
            }
        }
        return $result;
    }

    private function _stripQuotes($string)
    {
        return trim(str_replace('"', '', $string));
    }
}