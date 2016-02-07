<?php

namespace Mappers;

/**
 * Main interface of this application. Use this to parse and map invoices with payments
 *
 * @package Mappers
 */
interface Mapper
{
    /**
     * Map $invoices with Payments that are retrieved from $pathToFile using $parserName parser
     *
     * @param \ArrayObject $invoices Invoices to check
     * @param string $pathToSource Absolute path source, that contains payments
     * @param string $parserName Name of the parser to use while parsing file (see ParserFactory class)
     *
     * @return \ArrayObject List of invoices that were paid
     * @throws \Exception When file parsing fails, exception is thrown
     */
    public function map(\ArrayObject $invoices, $pathToSource, $parserName);
}