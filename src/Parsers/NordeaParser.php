<?php

namespace Parsers;

use Entities\Payment;

/**
 * Parser for Nordea CSV format documents
 *
 * @package Parsers
 */
class NordeaParser extends AbstractParser implements Parser
{
    /**
     * NordeaParser constructor.
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
            if (count($item) == 12) {
                $payment = new Payment($this->_stripQuotes($item[6]), $this->_stripQuotes($item[8]), $this->_stripQuotes($item[9]), $this->_stripQuotes($item[4]), $this->_stripQuotes($item[7]));
                $result->append($payment);
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