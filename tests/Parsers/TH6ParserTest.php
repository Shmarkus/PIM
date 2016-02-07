<?php

/**
 * Created by PhpStorm.
 * User: markus
 * Date: 5.02.16
 * Time: 12:49
 */
class TH6ParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Parsers\TH6Parser
     */
    private $_parser;

    public function testShouldGetPayments()
    {
        $data = '"EE581010220210497228";"43";"05.01.2016";"EE321010220233505223";"ORGANIC LOL POPS OÜ";"401";"MK";"C";          48,00;"";"RO1755898361";"Arve nr. 905/IT";0;"";"12685983"';
        $payments = $this->_parser->parseData($data);
        $this->assertEquals(new \Entities\Payment('48,00', 'RO1755898361', 'Arve nr. 905/IT', 'ORGANIC LOL POPS OÜ'), $payments->offsetGet(0));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_parser = new \Parsers\TH6Parser();
    }
}
