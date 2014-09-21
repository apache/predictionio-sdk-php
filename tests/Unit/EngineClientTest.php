<?php
namespace predictionio\tests\Unit;

use GuzzleHttp\Subscriber\History;
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use predictionio\EngineClient;

class EngineClientTest extends \PHPUnit_Framework_TestCase {
  protected $engineClient;
  protected $history;

  protected function setUp() {
    $this->engineClient=new EngineClient();
    $this->history=new History();
    $mock = new Mock([new Response(200)]);
    $this->engineClient->client->getEmitter()->attach($this->history);
    $this->engineClient->client->getEmitter()->attach($mock);
  }

  public function testSendQuery() {
    $this->engineClient->sendQuery(array('uid'=>5, 'iids'=>array(1,2,3)));
    $request=$this->history->getLastRequest();
    $body=json_decode($request->getBody(), true);

    $this->assertEquals(5,$body['uid']);
    $this->assertEquals(array(1,2,3),$body['iids']);
    $this->assertEquals('POST',$request->getMethod());
    $this->assertEquals('http://localhost:8000/queries.json',$request->getUrl());
  }

}

?>
