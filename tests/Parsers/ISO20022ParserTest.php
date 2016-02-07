<?php

/**
 * Created by PhpStorm.
 * User: markus
 * Date: 5.02.16
 * Time: 15:46
 */
class ISO20022ParserTest extends PHPUnit_Framework_TestCase
{
    private $RESOURCE_PATH = '/../resources/';

    /**
     * @var \Parsers\ISO20022Parser
     */
    private $_parser;

    public function testShouldReturnPayments()
    {
        $extractor = new \Extractors\FileExtractor();
        $data = $extractor->readFile(dirname(__FILE__) . $this->RESOURCE_PATH . 'swedStmt.xml');
        $payment = new \Entities\Payment('196.80', '2016010700183611-1', 'Arve nr. 8/NE', '');
        $payments = $this->_parser->parseData($data);
        $this->assertEquals($payment, $payments->offsetGet(1));
    }

    public function testShouldReturnPaymentsIncoming()
    {
        $extractor = new \Extractors\FileExtractor();
        $data = $extractor->readFile(dirname(__FILE__) . $this->RESOURCE_PATH . 'swedLaek.xml');
        $payment = new \Entities\Payment('75.00', '2016010400180147-1', 'Arve nr.274/RA', '');
        $payments = $this->_parser->parseData($data);
        $this->assertEquals($payment, $payments->offsetGet(1));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_parser = new \Parsers\ISO20022Parser();
    }

}
