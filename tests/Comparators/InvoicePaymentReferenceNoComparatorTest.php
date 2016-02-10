<?php

class InvoicePaymentReferenceNoComparatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Comparators\Comparator
     */
    private $comparator;

    public function testShouldMatchOne()
    {
        $invoices = new \ArrayObject();
        $invoice = new \Entities\SampleInvoice('48,00', '905/IT', '2016020508', '');
        $invoices->append($invoice);
        $payments = new \ArrayObject();
        $payments->append(new \Entities\Payment('48,00', 'RO1755898361', 'Arve nr. 905/IT', 'Company OÜ'));
        $payments->append(new \Entities\Payment('15,00', 'RO1756686260', 'Tellimus 365/PF', 'Firma AS'));
        $payments->append(new \Entities\Payment('85,20', 'RO1757162444', 'tellimus 353/PF 24,12,15', 'ISA JA POJAD OÜ'));
        $mapped = $this->comparator->compare($invoices, $payments);
        $this->assertEquals(1, $mapped->count());
        $this->assertEquals($invoice, $mapped->offsetGet(0)->getRelatedInvoice());
    }

    public function testShouldMatchNone()
    {
        $invoices = new \ArrayObject();
        $invoice = new \Entities\SampleInvoice('100', '666/AA', '2015120508', '');
        $invoices->append($invoice);
        $payments = new \ArrayObject();
        $payments->append(new \Entities\Payment('48,00', 'RO1755898361', 'Arve nr. 905/IT', 'Company OÜ'));
        $payments->append(new \Entities\Payment('15,00', 'RO1756686260', 'Tellimus 365/PF', 'Firma AS'));
        $payments->append(new \Entities\Payment('85,20', 'RO1757162444', 'tellimus 353/PF 24,12,15', 'ISA JA POJAD OÜ'));
        $mapped = $this->comparator->compare($invoices, $payments);
        $this->assertEquals(0, $mapped->count());
    }

    /**
     * @expectedException \Exception
     */
    public function testShouldThrowExceptionOnInvalidTypes()
    {
        $invalidItem = new stdClass();
        $invalidItem->invoiceNo = 'A1234';
        $invoices = new \ArrayObject(array($invalidItem));
        $payments = new \ArrayObject(array($invalidItem));
        $this->comparator->compare($invoices, $payments);
        $this->fail('Should have thrown an exception!');
    }

    protected function setUp()
    {
        parent::setUp();
        $this->comparator = new \Comparators\InvoicePaymentReferenceNoComparator();
    }
}
