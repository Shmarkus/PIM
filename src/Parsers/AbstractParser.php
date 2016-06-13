<?php

namespace Parsers;

/**
 * Abstract class implements common methods for all parsers
 *
 * @package Parsers
 */
abstract class AbstractParser
{
    /**
     * Array of payments retrieved using parser
     *
     * @var \ArrayObject
     */
    protected $_payments;

    /**
     * Apache Log4PHP logger object
     *
     * @var \Logger
     */
    protected $_logger;

    /**
     * Your invoice number regular expression pattern. This is meant to match invoices such as 1234/ABCDE
     *
     * @var string[]
     */
    protected $_patterns = ['/[0-9]+\/[a-zA-Z]+/', '/20[1-3][0-9][0-1][0-9][0-3][0-9][0-9]{2}/'];

    /**
     * AbstractParser constructor.
     */
    public function __construct()
    {
        $this->_payments = new \ArrayObject();
        $this->_logger = new \Logger(get_class($this));
    }

    /**
     * Parse document and return all payments as an array of Payments.
     *
     * @param String $stream Contents of the stream to parse
     * @return void
     *
     * @throws \Exception When problems parsing the stream
     */
    public function parse($stream)
    {
        $this->_payments = $this->parseData($stream);
    }

    abstract function parseData($stream);

    /**
     * Get parsed payments
     *
     * @return \ArrayObject Payments array
     */
    public function getPayments()
    {
        if ($this->_payments->count() == 0) {
            $this->_logger->info("No payments found, did you invoke Parser::parse() before this call?");
        }
        return $this->_payments;
    }

    protected function _getMatches($invoice)
    {
        $result = array();
        foreach ($this->_patterns as $pattern) {
            preg_match_all($pattern, $invoice, $matches);
            $result = array_merge($matches[0], $result);
        }
        return $result;
    }
}