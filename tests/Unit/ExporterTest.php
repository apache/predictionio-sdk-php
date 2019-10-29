<?php

/**
 * Licensed to the Apache Software Foundation (ASF) under one or more
 * contributor license agreements.  See the NOTICE file distributed with
 * this work for additional information regarding copyright ownership.
 * The ASF licenses this file to You under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with
 * the License.  You may obtain a copy of the License at
 *    http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace predictionio\tests\Unit;

use predictionio\Exporter;
use PHPUnit\Framework\TestCase;

class TestExporter
{
    use Exporter {
        jsonEncode as traitJsonEncode;
    }

    public $json;
    public $data;

    public function __construct()
    {
        $this->json = [];
        $this->data = [];
    }

    public function jsonEncode($data)
    {
        $this->data[] = $data;
        return $this->traitJsonEncode($data);
    }

    public function export($json)
    {
        $this->json[] = $json;
    }
}

class ExporterTest extends TestCase
{

    /** @var TestExporter $exporter */
    private $exporter;

    protected function setUp()
    {
        $this->exporter = new TestExporter();
    }

    public function testTimeIsNow()
    {
        $time = new \DateTime();

        $this->exporter->createEvent('event', 'entity-type', 'entity-id');

        $this->assertCount(1, $this->exporter->data);
        $data = $this->exporter->data[0];
        $this->assertCount(4, $data);
        $this->assertEquals('event', $data['event']);
        $this->assertEquals('entity-type', $data['entityType']);
        $this->assertEquals('entity-id', $data['entityId']);
        $this->assertEquals($time->format(\DateTime::ISO8601), $data['eventTime'], 'time is now', 1);

        $this->assertCount(1, $this->exporter->json);
        $json = $this->exporter->json[0];
        $pattern = '/^{"event":"event","entityType":"entity-type","entityId":"entity-id","eventTime":"\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{4}"}$/';
        $this->assertRegExp($pattern, $json, 'json');
    }

    public function testTimeIsString()
    {
        $time = new \DateTime('2015-04-01');

        $this->exporter->createEvent('event', 'entity-type', 'entity-id', null, null, null, '2015-04-01');

        $this->assertCount(1, $this->exporter->data);
        $data = $this->exporter->data[0];
        $this->assertCount(4, $data);
        $this->assertEquals('event', $data['event']);
        $this->assertEquals('entity-type', $data['entityType']);
        $this->assertEquals('entity-id', $data['entityId']);
        $this->assertEquals($time->format(\DateTime::ISO8601), $data['eventTime'], 'time is string', 1);

        $this->assertCount(1, $this->exporter->json);
        $json = $this->exporter->json[0];
        $pattern = '/^{"event":"event","entityType":"entity-type","entityId":"entity-id","eventTime":"\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{4}"}$/';
        $this->assertRegExp($pattern, $json, 'json');
    }

    public function testTimeIsDateTime()
    {
        $time = new \DateTime('2015-04-01');

        $this->exporter->createEvent('event', 'entity-type', 'entity-id', null, null, null, $time);

        $this->assertCount(1, $this->exporter->data);
        $data = $this->exporter->data[0];
        $this->assertCount(4, $data);
        $this->assertEquals('event', $data['event']);
        $this->assertEquals('entity-type', $data['entityType']);
        $this->assertEquals('entity-id', $data['entityId']);
        $this->assertEquals($time->format(\DateTime::ISO8601), $data['eventTime'], 'time is DateTime', 1);

        $this->assertCount(1, $this->exporter->json);
        $json = $this->exporter->json[0];
        $pattern = '/^{"event":"event","entityType":"entity-type","entityId":"entity-id","eventTime":"\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{4}"}$/';
        $this->assertRegExp($pattern, $json, 'json');
    }

    public function testOptionalFields()
    {
        $time = new \DateTime('2015-04-01');

        $this->exporter->createEvent(
            'event',
            'entity-type',
            'entity-id',
            'target-entity-type',
            'target-entity-id',
            ['property' => true],
            $time
        );

        $this->assertCount(1, $this->exporter->data);
        $data = $this->exporter->data[0];
        $this->assertCount(7, $data);
        $this->assertEquals('event', $data['event']);
        $this->assertEquals('entity-type', $data['entityType']);
        $this->assertEquals('entity-id', $data['entityId']);
        $this->assertEquals($time->format(\DateTime::ISO8601), $data['eventTime'], 'time is DateTime', 1);
        $this->assertEquals('target-entity-type', $data['targetEntityType']);
        $this->assertEquals('target-entity-id', $data['targetEntityId']);
        $this->assertEquals(['property'=>true], $data['properties']);

        $this->assertCount(1, $this->exporter->json);
        $json = $this->exporter->json[0];
        $pattern = '/^{"event":"event","entityType":"entity-type","entityId":"entity-id","eventTime":"\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{4}","targetEntityType":"target-entity-type","targetEntityId":"target-entity-id","properties":{"property":true}}$/';
        $this->assertRegExp($pattern, $json, 'json');
    }
}
