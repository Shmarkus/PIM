<?php

namespace Extractors;

/**
 * Interface describes extractor factory method
 *
 * @package Extractors
 */
interface ExtractorFactory
{
    /**
     * Determine correct extractor by name and retrieve the instance to it
     *
     * @param string $name Name of the extractor
     *
     * @return Extractor
     * @throws \Exception When called extractor name is not registered, exception is thrown
     */
    public function getExtractor($name);
}