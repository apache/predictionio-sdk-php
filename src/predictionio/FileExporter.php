<?php

namespace predictionio;

/**
 * Class FileExporter writes events to a series of JSON objects in a file for batch import.
 *
 * @package predictionio
 */
class FileExporter {

    use Exporter;

    private $file;

    public function __construct($fileName) {
        $this->file = fopen($fileName, 'w');
    }

    public function export($json) {
        fwrite($this->file, "$json\n");
    }

    public function close() {
        fclose($this->file);
    }
}