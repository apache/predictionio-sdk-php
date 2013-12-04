<?php

namespace PredictionIO\Tests\Unit;

use Guzzle\Common\Collection;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;
use PredictionIO\PredictionIOClient;

/**
 * Class PredictionIOClientTest
 *
 * @package PredictionIO\Tests
 */
class PredictionIOClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Guzzle\Common\Exception\InvalidArgumentException
     * @expectedMessage   Config must contain a 'appkey' key
     */
    public function testFactoryThrowsExceptionWithNoAppKey()
    {
        $config = array();
        PredictionIOClient::factory($config);
    }

    public function testFactoryReturnsNewClient()
    {
        $config = array(
            'appkey' => 'mock.appkey',
        );
        $client = PredictionIOClient::factory($config);

        $this->assertInstanceOf('\PredictionIO\PredictionIOClient', $client);
        $this->assertSame($config['appkey'], $client->getConfig('appkey'));
    }

    public function testFactoryWithDefaultApiUrlSuccess()
    {
        $defaultApiUrl = 'http://localhost:8000';
        $config = array(
            'appkey' => 'mock.appkey',
        );
        $client = PredictionIOClient::factory($config);

        $this->assertSame($defaultApiUrl, $client->getConfig('apiurl'));
    }

    public function testFactoryWithDefinedApiUrlSuccess()
    {
        $config = array(
            'appkey' => 'mock.appkey',
            'apiurl' => 'http://mock.api:1234',
        );
        $client = PredictionIOClient::factory($config);

        $this->assertSame($client->getConfig('apiurl'), $client->getConfig('apiurl'));
    }

    public function testFactoryWithCustomConfigSuccess()
    {
        $config = array(
            'appkey' => 'mock.appkey',
            'customconfig' => 'mock.option',
        );
        $client = PredictionIOClient::factory($config);

        $this->assertSame($client->getConfig('customconfig'), $client->getConfig('customconfig'));
    }

    /**
     * @expectedException        \PredictionIO\UnidentifiedUserException
     * @expectedExceptionMessage Must call identify() before performing any user-related commands.
     */
    public function testGetIdentityThrowsExceptionWhenNotSet()
    {
        $client = new PredictionIOClient();
        $client->getIdentity();
    }

    public function testSetGetIdentitySuccess()
    {
        $mockId = "0";
        $client = new PredictionIOClient();
        $client->identify($mockId);

        $this->assertSame($mockId, $client->getIdentity());
    }

    public function testCreateRequestReturnsRequestObject()
    {
        $client = new PredictionIOClient();
        $request = $client->createRequest();

        $this->assertInstanceOf('\Guzzle\Http\Message\Request', $request);
    }

    public function testCreateRequestSetMethodSuccess()
    {
        $mockMethod = RequestInterface::POST;
        $client = new PredictionIOClient();
        $request = $client->createRequest($mockMethod);

        $this->assertSame($mockMethod, $request->getMethod());
    }

    public function testCreateRequestSetUriSuccess()
    {
        $mockUri = 'http://mock.uri/method';
        $expectedUri = $mockUri.'.json?pio_appkey=';
        $client = new PredictionIOClient();
        $request = $client->createRequest(RequestInterface::GET, $mockUri);

        $this->assertSame($expectedUri, $request->getUrl());
    }

    public function testCreateRequestSetHeadersSuccess()
    {
        $headers = array(
            'mock.header' => 'mock.value',
        );
        $client = new PredictionIOClient();
        $request = $client->createRequest(RequestInterface::GET, null, $headers);

        $this->assertTrue($request->getHeader('mock.header')->hasValue($headers['mock.header']));
    }

    public function testCreateRequestUnsetsGuzzleInternals()
    {
        $body = array(
            AbstractCommand::HEADERS_OPTION => 'mock.HEADERS_OPTION',
            AbstractCommand::ON_COMPLETE => 'mock.ON_COMPLETE',
            AbstractCommand::DISABLE_VALIDATION => 'mock.DISABLE_VALIDATION',
            AbstractCommand::RESPONSE_PROCESSING => 'mock.RESPONSE_PROCESSING',
            AbstractCommand::RESPONSE_BODY => 'mock.RESPONSE_BODY',
        );
        $client = new PredictionIOClient();
        $request = $client->createRequest(RequestInterface::GET, null, null, $body);

        $this->assertNull($request->getQuery()->get(AbstractCommand::HEADERS_OPTION));
        $this->assertNull($request->getQuery()->get(AbstractCommand::ON_COMPLETE));
        $this->assertNull($request->getQuery()->get(AbstractCommand::DISABLE_VALIDATION));
        $this->assertNull($request->getQuery()->get(AbstractCommand::RESPONSE_PROCESSING));
        $this->assertNull($request->getQuery()->get(AbstractCommand::RESPONSE_BODY));
    }
}
