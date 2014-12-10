<?php
namespace predictionio\tests\Unit;

use GuzzleHttp\Subscriber\History;
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use predictionio\EventClient;

class EventClientTest extends \PHPUnit_Framework_TestCase {
  protected $eventClient;
  protected $history;

  protected function setUp() {
    $this->eventClient=new EventClient(
      "j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O");
    $this->history=new History();
    $mock = new Mock([new Response(200)]);
    $this->eventClient->client->getEmitter()->attach($this->history);
    $this->eventClient->client->getEmitter()->attach($mock);
  }

  public function testSetUser() {
    $this->eventClient->setUser(1,array('age'=>20));
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$set',$body['event']);
    $this->assertEquals('user',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertEquals(20,$body['properties']['age']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUrl());
  }

  public function testSetUserWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->setUser(1,array('age'=>20), $eventTime);
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$set',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  public function testUnsetUser() {
    $this->eventClient->unsetUser(1,array('age'=>20));
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$unset',$body['event']);
    $this->assertEquals('user',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertEquals(20,$body['properties']['age']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUrl());
  }

  public function testUnsetUserWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->unsetUser(1,array('age'=>20), $eventTime);
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$unset',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  /**
   * @expectedException predictionio\PredictionIOAPIError
   */
  public function testUnsetUserWithoutProperties() {
    $this->eventClient->unsetUser(1, array());
  }
  
  public function testDeleteUser() {
    $this->eventClient->deleteUser(1);
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$delete',$body['event']);
    $this->assertEquals('user',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUrl());
  }

  public function testDeleteUserWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->deleteUser(1, $eventTime);
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$delete',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  public function testSetItem() {
    $this->eventClient->setItem(1,array('type'=>'book'));
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$set',$body['event']);
    $this->assertEquals('item',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertEquals('book',$body['properties']['type']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUrl());
  }

  public function testSetItemWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->setItem(1,array('type'=>'book'), $eventTime);
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$set',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  public function testUnsetItem() {
    $this->eventClient->unsetItem(1,array('type'=>'book'));
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$unset',$body['event']);
    $this->assertEquals('item',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertEquals('book',$body['properties']['type']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUrl());
  }

  public function testUnsetItemWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->unsetItem(1,array('type'=>'book'), $eventTime);
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$unset',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  /**
   * @expectedException predictionio\PredictionIOAPIError
   */
  public function testUnsetItemWithoutProperties() {
    $this->eventClient->unsetItem(1, array());
  }

  public function testDeleteItem() {
    $this->eventClient->deleteItem(1);
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$delete',$body['event']);
    $this->assertEquals('item',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUrl());
  }

  public function testDeleteItemWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->deleteItem(1, $eventTime);
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('$delete',$body['event']);
    $this->assertEquals($eventTime, $body['eventTime']);
  }

  public function testRecordAction() {
    $this->eventClient->recordUserActionOnItem('view',1,888, array('count'=>2));
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('view',$body['event']);
    $this->assertEquals('user',$body['entityType']);
    $this->assertEquals(1,$body['entityId']);
    $this->assertEquals('item',$body['targetEntityType']);
    $this->assertEquals(888,$body['targetEntityId']);
    $this->assertEquals(2,$body['properties']['count']);
    $this->assertNotNull($body['eventTime']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUrl());
  }

  public function testRecordActionWithEventTime() {
    $eventTime='1982-09-25T01:23:45+0800';

    $this->eventClient->recordUserActionOnItem('view',1, 8, array(),$eventTime);
    $request=$this->history->getLastRequest();
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
    $request=$this->history->getLastRequest();
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
    $this->assertEquals('http://localhost:7070/events.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',$request->getUrl());
  }

  public function testGetEvent() {
    $this->eventClient->getEvent('event_id');
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals('GET',$request->getMethod());
    $this->assertEquals('http://localhost:7070/events/event_id.json?accessKey=j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O',
                $request->getUrl());
  }




}
?>

