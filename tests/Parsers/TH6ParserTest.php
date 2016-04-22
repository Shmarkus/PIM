<?php

class TH6ParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Parsers\TH6Parser
     */
    private $_parser;

    public function testShouldGetPayments()
    {
        $data = '"EE581010220000000000";"43";"05.01.2016";"EE321010221111111111";"COMPANY OÜ";"401";"MK";"C";          48,00;"";"RO1755898361";"Arve nr. 905/IT";0;"";"12685983"';
        $payments = $this->_parser->parseData($data);
        $this->assertEquals(new \Entities\Payment('48,00', 'RO1755898361', '905/IT', 'COMPANY OÜ'), $payments->offsetGet(0));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_parser = new \Parsers\TH6Parser();
    }
}
