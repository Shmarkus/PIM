<?php

namespace Parsers;

/**
 * Parser interface describes methods for parsing a specific source and then returning array of Payments
 *
 * @package Parsers
 */
interface Parser
{
    /**
     * Parse document and return all payments as an array of Payments.
     *
     * @param String $stream Contents of the stream to parse
     * @return void
     *
     * @throws \Exception When problems parsing the stream
     */
    public function parse($stream);

    /**
     * Return the payments that were parsed using parse() method
     *
     * @return \ArrayObject
     */
    public function getPayments();
}