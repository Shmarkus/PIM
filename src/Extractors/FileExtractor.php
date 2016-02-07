<?php

namespace Extractors;

/**
 * Extractor for retrieving data from source.
 *
 * @package Extractors
 */
class FileExtractor extends AbstractExtractor implements Extractor
{
    /**
     * Read data from source and pass it to correct Parser
     *
     * @param string $pathToSource Absolute path to source
     * @param string $parserName Name of the correct parser
     * @return void
     *
     * @throws \Exception When extract fails, exception is thrown
     */
    public function extractPayments($pathToSource, $parserName)
    {
        $source = $this->readFile($pathToSource);
        $parser = $this->_parserFactory->getParser($parserName);
        $parser->parse($source);
        $this->_payments = $parser->getPayments();
    }

    /**
     * Read file contents
     *
     * @param string $path Absolute path to file
     *
     * @return string File contents as string
     * @throws \Exception Exception is thrown when file is not found or file is empty
     */
    public function readFile($path)
    {
        if (file_exists($path)) {
            $contents = file_get_contents($path);
            if (strlen($contents) > 0) {
                return $contents;
            } else {
                throw new \Exception('File \'' . $path . '\' is 0bytes long!');
            }
        } else {
            throw new \Exception('File \'' . $path . '\' not found!');
        }
    }
}