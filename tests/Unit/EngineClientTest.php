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

use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use predictionio\EngineClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class EngineClientTest extends TestCase
{
    /** @var EngineClient $engineClient */
    protected $engineClient;
    protected $container = [];

    protected function setUp()
    {
        $history=Middleware::History($this->container);
        $mock=new MockHandler([new Response(200)]);
        $handler=HandlerStack::create($mock);
        $handler->push($history);
        $this->engineClient=new EngineClient();
        $existingOptions = $this->engineClient->client->getConfig();
        $existingOptions['handler'] = $handler;
        $mockClient=new Client($existingOptions);
        $this->engineClient->client = $mockClient;
    }

    public function testSendQuery()
    {
        $this->engineClient->sendQuery(array('uid'=>5, 'iids'=>array(1,2,3)));
        $result=array_shift($this->container);
        /** @var Request[] $result['request'] */
        $body=json_decode($result['request']->getBody(), true);

        $this->assertEquals(5, $body['uid']);
        $this->assertEquals(array(1,2,3), $body['iids']);
        $this->assertEquals('POST', $result['request']->getMethod());
        $this->assertEquals('http://localhost:8000/queries.json', $result['request']->getUri());
    }
}
