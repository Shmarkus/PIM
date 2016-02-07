<?php

namespace Extractors;

use Parsers\ParserFactory;
use Parsers\ParserFactoryImpl;

/**
 * This extractor abstract class implements common extractor methods used by all extractors
 *
 * @package Extractors
 */
abstract class AbstractExtractor implements Extractor
{
    /**
     * Attribute to hold extracted payments
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
     * Parser factory for retrieving correct parser by name
     *
     * @var ParserFactory
     */
    protected $_parserFactory;

    /**
     * ExtractorImpl constructor.
     */
    public function __construct()
    {
        $this->_payments = new \ArrayObject();
        $this->_logger = new \Logger(get_class($this));

        $this->setParserFactory(new ParserFactoryImpl());
    }

    /**
     * Initiate parser factory object. This method is for mocking purpose.
     *
     * @param ParserFactory $factory
     */
    public function setParserFactory(ParserFactory $factory)
    {
        $this->_parserFactory = $factory;
    }

    public abstract function extractPayments($pathToSource, $parserName);

    /**
     * Get extracted payments
     *
     * @return \ArrayObject Payments array
     */
    public function getPayments()
    {
        if ($this->_payments->count() == 0) {
            $this->_logger->info("No payments found, did you invoke Extractor::extractPayments() before this call?");
        }
        return $this->_payments;
    }

    /**
     * Get actual parser instance by name
     *
     * @param string $name Parser name
     * @return \Parsers\Parser
     * @throws \Exception When parser name is not registered
     */
    public function getParser($name)
    {
        return $this->_parserFactory->getParser($name);
    }
}