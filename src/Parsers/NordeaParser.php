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
        $rows = explode("\r\n", $stream);
        foreach (array_filter($rows) as $row) {
            $item = explode('";"', $row);
            if (count($item) == 12) {
                //multiple invoices paid
                if ($matches = $this->_getMatches($this->_stripQuotes($item[9]))) {
                    foreach ($matches as $match) {
                        $result->append(new Payment($this->_stripQuotes($item[6]), $this->_stripQuotes($item[8]), $match, $this->_stripQuotes($item[4]), $this->_stripQuotes($item[7])));
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