<?php

class NordeaParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Parsers\NordeaParser
     */
    private $_parser;

    public function testShouldGetPayments()
    {
        $data = '"EE591700010000000000";"";"04.01.2016";"EE367700771111111111";"Firma O�";"D";"334,77";"";"EX16004VX9X7WSR";"Tellimus 1234";"EUR";"12314000"';
        $payments = $this->_parser->parseData($data);
        $this->assertEquals(new \Entities\Payment('334,77', 'EX16004VX9X7WSR', 'Tellimus 1234', 'Firma O�'), $payments->offsetGet(0));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_parser = new \Parsers\NordeaParser();
    }
}
