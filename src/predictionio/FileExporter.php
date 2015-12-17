<?php

namespace predictionio;

/**
 * Class FileExporter writes events to a series of JSON objects in a file for batch import.
 *
 * @package predictionio
 */
class FileExporter
{
    use Exporter;

    /**
     * @var resource
     */
    private $file;

    /**
     * Constructor.
     *
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->file = fopen($fileName, 'w');
    }

    /**
     * Export
     *
     * @param string $json
     */
    public function export($json)
    {
        fwrite($this->file, "$json\n");
    }

    /**
     * Close
     */
    public function close()
    {
        fclose($this->file);
    }
}
