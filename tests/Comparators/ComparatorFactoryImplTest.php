<?php

class ComparatorFactoryImplTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Comparators\ComparatorFactoryImpl
     */
    private $factoryImpl;

    /**
     * @expectedException \Exception
     */
    public function testShouldThrowExceptionOnUnknownName()
    {
        $this->factoryImpl->getComparator("DoesNotExist");
    }

    public function testShouldReturnFileExtractor()
    {
        $obj = $this->factoryImpl->getComparator("IPRNo");
        $this->assertTrue($obj instanceof \Comparators\InvoicePaymentReferenceNoComparator);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->factoryImpl = new \Comparators\ComparatorFactoryImpl();
    }
}
