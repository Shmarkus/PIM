<?php
use Mockery as m;

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
        $data = $extractor->readFile(dirname(__FILE__) . $this->RESOURCE_PATH . 'iso20022.xml');
        $payment = new \Entities\Payment('123.45', '2016010700183611-1', 'Arve nr. 8/NE', 'Company OÜ');
        $payments = $this->_parser->parseData($data);
        $this->assertEquals($payment, $payments->offsetGet(0));
    }

    public function tearDown()
    {
        m::close();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_parser = new \Parsers\ISO20022Parser();
    }
}
