<?php

namespace Parsers;

/**
 * Implementation of parser factory. This class returns correct parser instance by name
 *
 * @package Parsers
 */
class ParserFactoryImpl implements ParserFactory
{
    /**
     * Determine correct parser by name and return the instance
     *
     * @param string $name Name of the parser
     *
     * @return Parser
     * @throws \Exception When unknown parser is called
     */
    public function getParser($name)
    {
        switch ($name) {
            case 'ISO20022':
                return new ISO20022Parser();
            case 'TH6':
                return new TH6Parser();
            case 'Nordea':
                return new NordeaParser();
            case 'NordeaTH':
                return new NordeaTHParser();
            case 'SEBTransactionImport':
                return new SEBTransactionImportParser();
            default:
                throw new \Exception('Unknown parser: ' . $name);
        }
    }
}