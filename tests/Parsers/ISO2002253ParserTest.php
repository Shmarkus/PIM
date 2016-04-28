<?php

use Mockery as m;

class ISO2002253ParserTest extends PHPUnit_Framework_TestCase
{

    private $RESOURCE_PATH = '/../resources/';

    /**
     * @var \Parsers\ISO20022Parser
     */
    private $_parser;

    public function testShouldReturnOrderPayments()
    {
        $extractor = new \Extractors\FileExtractor();
        $data = $extractor->readFile(dirname(__FILE__) . $this->RESOURCE_PATH . 'lhv.xml');
        $payment = new \Entities\Payment('657.60', '', '2016042022', 'Testing');
        $payments = $this->_parser->parseData($data);
        $this->assertEquals($payment, $payments->offsetGet(0));
    }

    public function testShouldReturnPayments()
    {
        $extractor = new \Extractors\FileExtractor();
        $data = $extractor->readFile(dirname(__FILE__) . $this->RESOURCE_PATH . 'lhv.xml');
        $payment = new \Entities\Payment('256.00', '', '108/V', 'Testing');
        $payments = $this->_parser->parseData($data);
        $this->assertEquals($payment, $payments->offsetGet(2));
    }

    public function tearDown()
    {
        m::close();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_parser = new \Parsers\ISO2002253Parser();
    }
}
