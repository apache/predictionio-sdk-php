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


use predictionio\FileExporter;

class FileExporterTest extends \PHPUnit_Framework_TestCase {

    public function setUp()
    {
        register_shutdown_function(function () {
            if (file_exists('temp.file')) {
                unlink('temp.file');
            }
        });
    }

    public function testExporter() {
        $exporter = new FileExporter('temp.file');
        $exporter->createEvent('event-1', 'entity-type-1', 'entity-id-1',
            null, null, null, '2015-04-01');
        $exporter->createEvent('event-2', 'entity-type-2', 'entity-id-2',
            'target-entity-type-2', 'target-entity-id-2', ['property' => 'blue'], '2015-04-01');
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
