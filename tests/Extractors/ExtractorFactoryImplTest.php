<?php

class ExtractorFactoryImplTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Extractors\ExtractorFactoryImpl
     */
    private $factoryImpl;

    /**
     * @expectedException \Exception
     */
    public function testShouldThrowExceptionOnUnknownName()
    {
        $this->factoryImpl->getExtractor("DoesNotExist");
    }

    public function testShouldReturnFileExtractor()
    {
        $obj = $this->factoryImpl->getExtractor("File");
        $this->assertTrue($obj instanceof \Extractors\FileExtractor);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->factoryImpl = new \Extractors\ExtractorFactoryImpl();
    }
}
