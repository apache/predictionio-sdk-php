<?php

namespace predictionio\tests\Unit;

use predictionio\Exporter;

/**
 * Class TestExporter
 *
 * @package predictionio\tests\Unit
 */
class TestExporter
{
    use Exporter {
        jsonEncode as traitJsonEncode;
    }

    /**
     * @var array
     */
    public $json;

    /**
     * @var array
     */
    public $data;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->json = [];
        $this->data = [];
    }

    /**
     * Json Encode
     *
     * @param $data
     * @return string
     */
    public function jsonEncode($data)
    {
        $this->data[] = $data;

        return $this->traitJsonEncode($data);
    }

    /**
     * Export
     *
     * @param $json
     */
    public function export($json)
    {
        $this->json[] = $json;
    }
}

/**
 * Class ExporterTest
 *
 * @package predictionio\tests\Unit
 */
class ExporterTest extends \PHPUnit_Framework_TestCase
{

    /** @var TestExporter $exporter */
    private $exporter;

    /**
     * SetUp
     */
    protected function setUp()
    {
        $this->exporter = new TestExporter();
    }

    /**
     * Test Time Is Now
     */
    public function testTimeIsNow()
    {
        $time = new \DateTime();

        $this->exporter->createEvent('event', 'entity-type', 'entity-id');

        $this->assertEquals(1, count($this->exporter->data));
        $data = $this->exporter->data[0];
        $this->assertEquals(4, count($data));
        $this->assertEquals('event', $data['event']);
        $this->assertEquals('entity-type', $data['entityType']);
        $this->assertEquals('entity-id', $data['entityId']);
        $this->assertEquals($time->format(\DateTime::ISO8601), $data['eventTime'], 'time is now', 1);

        $this->assertEquals(1, count($this->exporter->json));
        $json = $this->exporter->json[0];
        $pattern = '/^{"event":"event","entityType":"entity-type","entityId":"entity-id","eventTime":"\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{4}"}$/';
        $this->assertTrue(preg_match($pattern, $json) === 1, 'json');
    }

    /**
     * Test Time Is String
     */
    public function testTimeIsString()
    {
        $time = new \DateTime('2015-04-01');

        $this->exporter->createEvent('event', 'entity-type', 'entity-id', null, null, null, '2015-04-01');

        $this->assertEquals(1, count($this->exporter->data));
        $data = $this->exporter->data[0];
        $this->assertEquals(4, count($data));
        $this->assertEquals('event', $data['event']);
        $this->assertEquals('entity-type', $data['entityType']);
        $this->assertEquals('entity-id', $data['entityId']);
        $this->assertEquals($time->format(\DateTime::ISO8601), $data['eventTime'], 'time is string', 1);

        $this->assertEquals(1, count($this->exporter->json));
        $json = $this->exporter->json[0];
        $pattern = '/^{"event":"event","entityType":"entity-type","entityId":"entity-id","eventTime":"\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{4}"}$/';
        $this->assertTrue(preg_match($pattern, $json) === 1, 'json');
    }

    /**
     * Test Time Is DateTime
     */
    public function testTimeIsDateTime()
    {
        $time = new \DateTime('2015-04-01');

        $this->exporter->createEvent('event', 'entity-type', 'entity-id', null, null, null, $time);

        $this->assertEquals(1, count($this->exporter->data));
        $data = $this->exporter->data[0];
        $this->assertEquals(4, count($data));
        $this->assertEquals('event', $data['event']);
        $this->assertEquals('entity-type', $data['entityType']);
        $this->assertEquals('entity-id', $data['entityId']);
        $this->assertEquals($time->format(\DateTime::ISO8601), $data['eventTime'], 'time is DateTime', 1);

        $this->assertEquals(1, count($this->exporter->json));
        $json = $this->exporter->json[0];
        $pattern = '/^{"event":"event","entityType":"entity-type","entityId":"entity-id","eventTime":"\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{4}"}$/';
        $this->assertTrue(preg_match($pattern, $json) === 1, 'json');
    }

    /**
     * Test Optional Fields
     */
    public function testOptionalFields()
    {
        $time = new \DateTime('2015-04-01');

        $this->exporter->createEvent('event', 'entity-type', 'entity-id',
            'target-entity-type', 'target-entity-id', ['property' => true], $time);

        $this->assertEquals(1, count($this->exporter->data));
        $data = $this->exporter->data[0];
        $this->assertEquals(7, count($data));
        $this->assertEquals('event', $data['event']);
        $this->assertEquals('entity-type', $data['entityType']);
        $this->assertEquals('entity-id', $data['entityId']);
        $this->assertEquals($time->format(\DateTime::ISO8601), $data['eventTime'], 'time is DateTime', 1);
        $this->assertEquals('target-entity-type', $data['targetEntityType']);
        $this->assertEquals('target-entity-id', $data['targetEntityId']);
        $this->assertEquals(['property'=>true], $data['properties']);

        $this->assertEquals(1, count($this->exporter->json));
        $json = $this->exporter->json[0];
        $pattern = '/^{"event":"event","entityType":"entity-type","entityId":"entity-id","eventTime":"\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{4}","targetEntityType":"target-entity-type","targetEntityId":"target-entity-id","properties":{"property":true}}$/';
        $this->assertTrue(preg_match($pattern, $json) === 1, 'json');
    }
}
