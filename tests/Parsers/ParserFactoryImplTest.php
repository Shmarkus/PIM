<?php

class ParserFactoryImplTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Parsers\ParserFactoryImpl
     */
    private $_parserFactory;

    /**
     * @expectedException \Exception
     */
    public function testShouldThrowExceptionOnUnknownName()
    {
        $this->_parserFactory->getParser("DoesNotExist");
    }

    public function testShouldReturnISO20022Parser()
    {
        $parser = $this->_parserFactory->getParser("ISO20022-52");
        $this->assertTrue($parser instanceof \Parsers\ISO2002252Parser);
    }

    public function testShouldReturnTH6Parser()
    {
        $parser = $this->_parserFactory->getParser("TH6");
        $this->assertTrue($parser instanceof \Parsers\TH6Parser);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_parserFactory = new \Parsers\ParserFactoryImpl();
    }
}
