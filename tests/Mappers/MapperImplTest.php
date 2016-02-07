<?php

/**
 * Created by PhpStorm.
 * User: markus
 * Date: 5.02.16
 * Time: 21:46
 */
class MapperImplTest extends PHPUnit_Framework_TestCase
{
    private $RESOURCE_PATH = '/../resources/';
    /**
     * @var \Mappers\MapperImpl
     */
    private $_mapper;

    /**
     * @expectedException \Exception
     */
    public function testShouldThrowExceptionInvalidInvoice()
    {
        $invoice = new stdClass();
        $invoice->amount = '10,5';

        $invoices = new \ArrayObject();
        $invoices->append($invoice);
        $this->_mapper->map($invoices, dirname(__FILE__) . $this->RESOURCE_PATH . 'swedStmt.xml', 'ISO20022');
        $this->fail('Should have thrown exception!');
    }

    public function testShouldMapThreeInvoices()
    {
        $invoices = new \ArrayObject();
        $invoices->append(new \Entities\SampleInvoice('48,00', '903/IT', '2016020508', ''));
        $invoices->append(new \Entities\SampleInvoice('15,00', '', '365/PF', ''));
        $invoices->append(new \Entities\SampleInvoice('85,20', '', '353/PF', ''));
        $invoices->append(new \Entities\SampleInvoice('100', '666/AA', '2015120508', ''));
        $mapped = $this->_mapper->map($invoices, dirname(__FILE__) . $this->RESOURCE_PATH . 'seb_kvv_laek.csv', 'TH6');
        $this->assertEquals(3, $mapped->count());
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_mapper = new \Mappers\MapperImpl();
    }
}
