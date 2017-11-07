<?php
namespace predictionio\tests\Unit;

use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use predictionio\EngineClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class EngineClientTest extends TestCase {
  /** @var EngineClient $engineClient */
  protected $engineClient;
  protected $container = [];

  protected function setUp() {
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

  public function testSendQuery() {
    $this->engineClient->sendQuery(array('uid'=>5, 'iids'=>array(1,2,3)));
    $result=array_shift($this->container);
    /** @var Request[] $result['request'] */
    $body=json_decode($result['request']->getBody(), true);

    $this->assertEquals(5,$body['uid']);
    $this->assertEquals(array(1,2,3),$body['iids']);
    $this->assertEquals('POST',$result['request']->getMethod());
    $this->assertEquals('http://localhost:8000/queries.json',$result['request']->getUri());
  }

}
