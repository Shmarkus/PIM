<?php

/**
 * Created by PhpStorm.
 * User: markus
 * Date: 9.02.16
 * Time: 23:52
 */
class InvoicePaymentReferenceNoComparatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Comparators\Comparator
     */
    private $comparator;

    public function testShouldMatchOne()
    {

    }

    public function testShouldMatchNone()
    {

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
