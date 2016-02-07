<?php

namespace Extractors;

/**
 * The extractor interface covers the extraction methods. Main responsibility is to get source path,
 * handle reading the source, handle correct parser invocation, pass data to parser and return Payments
 *
 * @package Extractors
 */
interface Extractor
{
    /**
     * Get extracted payments
     *
     * @return \ArrayObject Payments array
     */
    public function getPayments();

    /**
     * Read data from source and pass it to correct Parser
     *
     * @param string $pathToSource Absolute path to source
     * @param string $parserName Name of the correct parser
     * @return void
     *
     * @throws \Exception When extract fails, exception is thrown
     */
    public function extractPayments($pathToSource, $parserName);
}