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

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use predictionio\EventClient;

class EventClientTest extends \PHPUnit_Framework_TestCase {
  /** @var  EventClient $eventClient */
  protected $eventClient;
  protected $container = [];

  protected function setUp() {
    $history=Middleware::History($this->container);
    $mock=new MockHandler([new Response(200)]);
    $handler=HandlerStack::create($mock);
    $handler->push($history);
    $this->eventClient=new EventClient(
        "j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O");
    $existingOptions = $this->eventClient->client->getConfig();
    $existingOptions['handler'] = $handler;
    $mockClient=new Client($existingOptions);
    $this->eventClient->client = $mockClient;
  }

  public function testSetUser() {
    $this->eventClient->setUser(1,array('age'=>20));
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$set',$body['event']);
    $this->assertEquals('user',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertEquals(20,$body['properties']['age']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUri());
  }

  public function testSetUserWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->setUser(1,array('age'=>20), $eventTime);
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$set',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  public function testUnsetUser() {
    $this->eventClient->unsetUser(1,array('age'=>20));
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$unset',$body['event']);
    $this->assertEquals('user',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertEquals(20,$body['properties']['age']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUri());
  }

  public function testUnsetUserWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->unsetUser(1,array('age'=>20), $eventTime);
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$unset',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  /**
   * @expectedException \predictionio\PredictionIOAPIError
   */
  public function testUnsetUserWithoutProperties() {
    $this->eventClient->unsetUser(1, array());
  }

  public function testDeleteUser() {
    $this->eventClient->deleteUser(1);
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$delete',$body['event']);
    $this->assertEquals('user',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUri());
  }

  public function testDeleteUserWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->deleteUser(1, $eventTime);
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$delete',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  public function testSetItem() {
    $this->eventClient->setItem(1,array('type'=>'book'));
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$set',$body['event']);
    $this->assertEquals('item',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertEquals('book',$body['properties']['type']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUri());
  }

  public function testSetItemWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->setItem(1,array('type'=>'book'), $eventTime);
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$set',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  public function testUnsetItem() {
    $this->eventClient->unsetItem(1,array('type'=>'book'));
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$unset',$body['event']);
    $this->assertEquals('item',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertEquals('book',$body['properties']['type']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUri());
  }

  public function testUnsetItemWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->unsetItem(1,array('type'=>'book'), $eventTime);
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$unset',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  /**
   * @expectedException \predictionio\PredictionIOAPIError
   */
  public function testUnsetItemWithoutProperties() {
    $this->eventClient->unsetItem(1, array());
  }

  public function testDeleteItem() {
    $this->eventClient->deleteItem(1);
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$delete',$body['event']);
    $this->assertEquals('item',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUri());
  }

  public function testDeleteItemWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->deleteItem(1, $eventTime);
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$delete',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  public function testRecordAction() {
    $this->eventClient->recordUserActionOnItem('view',1,888, array('count'=>2));
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('view',$body['event']);
    $this->assertEquals('user',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertEquals('item',$body['targetEntityType']);
    $this->assertEquals(888,$body['targetEntityId']);
    $this->assertEquals(2,$body['properties']['count']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUri());
  }

  public function testRecordActionWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->recordUserActionOnItem('view',1, 8, array(),$eventTime);
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('view',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  public function testCreateEvent() {
    $this->eventClient->createEvent(array(
                        'event' => 'my_event',
                        'entityType' => 'user',
                        'entityId' => 'uid',
                        'properties' => array('prop1'=>1,
                                              'prop2'=>'value2',
                                              'prop3'=>array(1,2,3),
                                              'prop4'=>true,
                                              'prop5'=>array('a','b','c'),
                                              'prop6'=>4.56
                                        ),
                        'eventTime' => '2004-12-13T21:39:45.618-07:00'
                       ));
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('my_event',$body['event']);
    $this->assertEquals('user',$body['entityType']);
    $this->assertEquals('uid',$body['entityId']);
    $this->assertEquals(1,$body['properties']['prop1']);
    $this->assertEquals('value2',$body['properties']['prop2']);
    $this->assertEquals(array(1,2,3),$body['properties']['prop3']);
    $this->assertEquals(true,$body['properties']['prop4']);
    $this->assertEquals(array('a','b','c'),$body['properties']['prop5']);
    $this->assertEquals(4.56,$body['properties']['prop6']);
    $this->assertEquals('2004-12-13T21:39:45.618-07:00',$body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUri());
  }

  public function testGetEvent() {
    $this->eventClient->getEvent('event_id');
    $result=array_shift($this->container);
    /** @var Request $request */
    $request=$result['request'];
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('GET',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events/event_id.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',
                $request->getUri());
  }




}
?>
