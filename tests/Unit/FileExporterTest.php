<?php

namespace predictionio\tests\Unit;

use predictionio\FileExporter;

/**
 * Class FileExporterTest
 *
 * @package predictionio\tests\Unit
 */
class FileExporterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * SetUp
     */
    public function setUp()
    {
        register_shutdown_function(function () {
            if (file_exists('temp.file')) {
                unlink('temp.file');
            }
        });
    }

    /**
     * Test Exporter
     */
    public function testExporter()
    {
        $exporter = new FileExporter('temp.file');
        $exporter->createEvent('event-1', 'entity-type-1', 'entity-id-1', null, null, null, '2015-04-01');
        $exporter->createEvent('event-2', 'entity-type-2', 'entity-id-2', 'target-entity-type-2', 'target-entity-id-2',
            ['property' => 'blue'], '2015-04-01');
        $exporter->close();

        $exported = file_get_contents('temp.file');

        $date = new \DateTime('2015-04-01');
        $expectedDate = $date->format(\DateTime::ISO8601);

        $expected =<<<EOS
{"event":"event-1","entityType":"entity-type-1","entityId":"entity-id-1","eventTime":"$expectedDate"}
{"event":"event-2","entityType":"entity-type-2","entityId":"entity-id-2","eventTime":"$expectedDate","targetEntityType":"target-entity-type-2","targetEntityId":"target-entity-id-2","properties":{"property":"blue"}}

EOS;

        $this->assertEquals($expected, $exported);
    }
}
