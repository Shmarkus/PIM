<?php

namespace Extractors;

/**
 * Implementation of extractor factory. This class returns correct extractor instance by name
 *
 * @package Extractors
 */
class ExtractorFactoryImpl implements ExtractorFactory
{
    /**
     * Determine correct extractor by name and return the instance
     *
     * @param string $name Name of the extractor
     *
     * @return Extractor
     * @throws \Exception When unknown extractor is called
     */
    public function getExtractor($name)
    {
        switch ($name) {
            case 'File':
                return new FileExtractor();
            default:
                throw new \Exception('Unknown extractor: ' . $name);
        }
    }
}