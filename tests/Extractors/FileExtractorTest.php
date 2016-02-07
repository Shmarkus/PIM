<?php

/**
 * Created by PhpStorm.
 * User: markus
 * Date: 5.02.16
 * Time: 11:50
 */
class FileExtractorTest extends PHPUnit_Framework_TestCase
{
    private $RESOURCE_PATH = '/../resources/';
    /**
     * @var \Extractors\FileExtractor
     */
    private $_extractor;

    /**
     * @expectedException \Exception
     */
    public function testShouldThrowExceptionOnNotExistingFile()
    {
        $this->_extractor->readFile(dirname(__FILE__) . $this->RESOURCE_PATH . 'notHere.csv');
    }

    /**
     * @expectedException \Exception
     */
    public function testShouldThrowExceptionOnEmptyFile()
    {
        $this->_extractor->readFile(dirname(__FILE__) . $this->RESOURCE_PATH . 'emptyFile.csv');
    }

    public function testShouldReturnFileContents()
    {
        $data = '[{"Invoice": "A1234","Account": "EE000001","Amount": 12.5,"Description": "blah blah"},{"Invoice": "B4321","Account": "EE000002","Amount": 1500,"Description": "This is a test"}]';
        $contents = $this->_extractor->readFile(dirname(__FILE__) . $this->RESOURCE_PATH . 'payments.json');
        $this->assertEquals($data, $contents);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->_extractor = new \Extractors\FileExtractor();
    }


}
