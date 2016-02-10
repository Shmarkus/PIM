<?php

class NordeaTHParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Parsers\NordeaTHParser
     */
    private $_parser;

    public function testShouldGetPayments()
    {
        $data = 'VV  1160104EX16004VX9    17001511824   EUREE367700771111111111               Firma O�                                   Tellimus 1234                                                              C 000000033477';
        $payments = $this->_parser->parseData($data);
        $this->assertEquals(new \Entities\Payment('334,77', 'EX16004VX9', 'Tellimus 1234', 'Firma O�'), $payments->offsetGet(0));
    }

    public function testShouldAvoidNonPayments()
    {
        $data = <<<DATA
VV  00080117001511824   1601090922
VV  2160101              17001511824   EUR                                                                                                                                                         C 000000000339
VV  1160104EX16004VX9    17001511824   EUREE367700771111111111               Firma O�                                   Tellimus 1234                                                              C 000000033477
DATA;
        $payments = $this->_parser->parseData($data);
        $this->assertEquals(1, $payments->count());
    }

    public function testShouldHonorEOF()
    {
        $data = <<<DATA
VV  1160104EX16004VX9    17001511824   EUREE367700771111111111               Firma O�                                   Tellimus 1234                                                              C 000000033477
VV  3160111              17001511824   EUR                                                                                                                                                         C 000000000816
VV  999
DATA;
        $payments = $this->_parser->parseData($data);
        $this->assertEquals(1, $payments->count());
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_parser = new \Parsers\NordeaTHParser();
    }
}
