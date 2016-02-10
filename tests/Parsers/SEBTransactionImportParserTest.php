<?php

class SEBTransactionImportParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Parsers\SEBTransactionImportParser
     */
    private $_parser;

    public function testShouldGetPayments()
    {
        $data = <<<DATA
#6
10
EE581010220210497228
EUR
090120161000
05012016
09012016
        60471
04012016
          100
        56054
       116425
#7
14
R1755898361L02
05012016
43

         4800
YOURCOMPANY O�
EE321010221111111111
Arve nr. 905/IT


401
12685983
05012016

#7
14
R1756041944L02
05012016


         3750
ISA JA POJAD O�
EE582200222222222222
arve.nr 895/IT


767
12544582
05012016


DATA;
        $payments = $this->_parser->parseData($data);
        $this->assertEquals(2, $payments->count());
        $this->assertEquals(new \Entities\Payment('48,00', 'R1755898361L02', 'Arve nr. 905/IT', 'YOURCOMPANY O�'), $payments->offsetGet(0));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_parser = new \Parsers\SEBTransactionImportParser();
    }
}
