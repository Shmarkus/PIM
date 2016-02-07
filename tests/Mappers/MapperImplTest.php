<?php
use Mockery as m;

class MapperImplTest extends PHPUnit_Framework_TestCase
{
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

        $payments = new \ArrayObject();
        $payments->append(new \Entities\Payment('196.80', '2016010700183611-1', 'Arve nr. 8/NE', 'KUMMIHAI OÜ'));
        $extractorMock = m::mock('extractor');
        $extractorMock->shouldReceive('extractPayments')->times(1);
        $extractorMock->shouldReceive('getPayments')->times(1)->andReturn($payments);

        $this->_mapper->setExtractor($extractorMock);
        $this->_mapper->map($invoices, 'file_is_mocked.xml', 'ISO20022');
        $this->fail('Should have thrown exception!');
    }

    public function testShouldMapThreeInvoices()
    {
        $invoices = new \ArrayObject();
        $invoices->append(new \Entities\SampleInvoice('48,00', '905/IT', '2016020508', ''));
        $invoices->append(new \Entities\SampleInvoice('15,00', '', '365/PF', ''));
        $invoices->append(new \Entities\SampleInvoice('85,20', '', '353/PF', ''));
        $invoices->append(new \Entities\SampleInvoice('100', '666/AA', '2015120508', ''));

        $payments = new \ArrayObject();
        $payments->append(new \Entities\Payment('48,00', 'RO1755898361', 'Arve nr. 905/IT', 'Company OÜ'));
        $payments->append(new \Entities\Payment('15,00', 'RO1756686260', 'Tellimus 365/PF', 'Firma AS'));
        $payments->append(new \Entities\Payment('85,20', 'RO1757162444', 'tellimus 353/PF 24,12,15', 'ISA JA POJAD OÜ'));
        $payments->append(new \Entities\Payment('100.80', '2016010700183611-1', 'Arve nr. 8/NE', 'EXPERDID OÜ'));
        $payments->append(new \Entities\Payment('196.99', 'RO1757164672', 'Tellimus', 'AS OÜ'));
        $payments->append(new \Entities\Payment('10.50', '2016020700153611-1', '-', 'kiiredjavihased OÜ'));
        $extractorMock = m::mock('extractor');
        $extractorMock->shouldReceive('extractPayments')->times(1);
        $extractorMock->shouldReceive('getPayments')->times(1)->andReturn($payments);

        $this->_mapper->setExtractor($extractorMock);

        $mapped = $this->_mapper->map($invoices, 'file_is_mocked.csv', 'TH6');
        $this->assertEquals(3, $mapped->count());
    }

    public function tearDown()
    {
        m::close();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_mapper = new \Mappers\MapperImpl();
    }
}
