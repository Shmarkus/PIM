<?php

namespace Mappers;

use Comparators\Comparator;
use Comparators\ComparatorFactoryImpl;
use Extractors\Extractor;
use Extractors\ExtractorFactoryImpl;

/**
 * Implementation of mapper. Use this to map invoices with payments
 *
 * @package Mappers
 */
class MapperImpl implements Mapper
{

    /**
     * Apache Log4PHP logger object
     *
     * @var \Logger
     */
    private $_logger;

    /**
     * @var Extractor
     */
    private $_extractor;
    /**
     * @var Comparator
     */
    private $_comparator;

    /**
     * MapperImpl constructor.
     *
     * @param string $comparatorName Name of the comparator, default is 'IPRNo'
     * @param string $extractorName Name of the extractor to use, default is 'File'
     */
    public function __construct($comparatorName = 'IPRNo', $extractorName = 'File')
    {
        $this->_logger = new \Logger(get_class($this));
        $extractorFactory = new ExtractorFactoryImpl();
        $comparatorFactory = new ComparatorFactoryImpl();
        $this->setExtractor($extractorFactory->getExtractor($extractorName));
        $this->setComparator($comparatorFactory->getComparator($comparatorName));
    }

    /**
     * Set current extractor factory
     *
     * @param Extractor $extractor Extractor to use
     */
    public function setExtractor($extractor)
    {
        $this->_extractor = $extractor;
    }

    /**
     * Set current comparator
     *
     * @param Comparator $comparator Comparator to use
     */
    public function setComparator($comparator)
    {
        $this->_comparator = $comparator;
    }

    /**
     * Map Invoices with Payments
     *
     * @param \ArrayObject $invoices Invoices to check
     * @param string $pathToSource Absolute path source, that contains payments
     * @param string $parserName Name of the parser to use while parsing file (see ParserFactory class)
 *
     * @return \ArrayObject Payments that had matching invoices
     * @throws \Exception When mapping fails, exception is thrown
     */
    public function map(\ArrayObject $invoices, $pathToSource, $parserName)
    {
        $this->_extractor->extractPayments($pathToSource, $parserName);
        $payments = $this->_extractor->getPayments();
        $results = $this->_comparator->compare($invoices, $payments);
        return $results;
    }

}