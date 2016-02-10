<?php

namespace Mappers;

use Comparators\ComparatorFactory;
use Comparators\ComparatorFactoryImpl;
use Extractors\ExtractorFactory;
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
     * @var ExtractorFactory
     */
    private $_extractorFactory;
    /**
     * @var ComparatorFactory
     */
    private $_comparatorFactory;

    /**
     * MapperImpl constructor.
     */
    public function __construct()
    {
        $this->_logger = new \Logger(get_class($this));
        $this->setExtractorFactory(new ExtractorFactoryImpl());
        $this->setComparatorFactory(new ComparatorFactoryImpl());
    }

    /**
     * Set current extractor factory
     *
     * @param ExtractorFactory $factory Extractor factory to use in this class
     */
    public function setExtractorFactory($factory)
    {
        $this->_extractorFactory = $factory;
    }

    /**
     * Set current comparator factory
     *
     * @param ComparatorFactory $factory Comparator factory to use
     */
    public function setComparatorFactory($factory)
    {
        $this->_comparatorFactory = $factory;
    }

    /**
     * Map $invoices with Payments that are retrieved from $pathToFile using $parserName parser
     *
     * @param \ArrayObject $invoices Invoices to check
     * @param string $pathToSource Absolute path source, that contains payments
     * @param string $parserName Name of the parser to use while parsing file (see ParserFactory class)
     * @param string $comparatorName Name of the comparator, default is 'IPRNo'
     * @param string $extractorName Name of the extractor to use, default is 'File'
     *
     * @return \ArrayObject List of invoices that were paid
     * @throws \Exception When file parsing fails, exception is thrown
     */
    public function map(\ArrayObject $invoices, $pathToSource, $parserName, $comparatorName = 'IPRNo', $extractorName = 'File')
    {
        $extractor = $this->_extractorFactory->getExtractor($extractorName);
        $comparator = $this->_comparatorFactory->getComparator($comparatorName);

        $extractor->extractPayments($pathToSource, $parserName);
        $payments = $extractor->getPayments();
        $results = $comparator->compare($invoices, $payments);
        return $results;
    }

}