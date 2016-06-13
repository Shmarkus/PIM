<?php

class NordeaParserTest extends PHPUnit_Framework_TestCase
{
    private $RESOURCE_PATH = '/../resources/';

    /**
     * @var \Parsers\NordeaParser
     */
    private $_parser;

    public function testShouldGetPayments()
    {
        $data = '"EE591700010000000000";"";"04.01.2016";"EE367700771111111111";"Firma O�";"D";"334,77";"";"EX16004VX9X7WSR";"Tellimus 2016041921";"EUR";"12314000"';
        $payments = $this->_parser->parseData($data);
        $this->assertEquals(new \Entities\Payment('334,77', 'EX16004VX9X7WSR', '2016041921', 'Firma O�'), $payments->offsetGet(0));
    }

    public function testShouldParseCSVFile()
    {
        $extractor = new \Extractors\FileExtractor();
        $data = $extractor->readFile(dirname(__FILE__) . $this->RESOURCE_PATH . 'default_layout.csv');
        $payments = $this->_parser->parseData($data);
        $this->assertEquals(1, $payments->count());
        $payment = $payments->offsetGet(0);
        $this->assertEquals(new \Entities\Payment('110,40', 'EX161587VV708ZZ', '2016060403', 'FIRMALISED', '20160604038'), $payment);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_parser = new \Parsers\NordeaParser();
    }
}
