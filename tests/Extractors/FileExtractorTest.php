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

    protected function setUp()
    {
        parent::setUp();
        $this->_extractor = new \Extractors\FileExtractor();
    }


}
