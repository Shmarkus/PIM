<?php

namespace Parsers;

/**
 * Interface describes parser factory method
 *
 * @package Parsers
 */
interface ParserFactory
{
    /**
     * Determine correct parser by name and retrieve the instance to it
     *
     * @param string $name Name of the parser
     *
     * @return Parser
     * @throws \Exception When called parser name is not registered, exception is thrown
     */
    public function getParser($name);
}