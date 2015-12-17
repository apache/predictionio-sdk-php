<?php

namespace predictionio;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Base client for Event and Engine client
 *
 * @package predictionio
 */
abstract class BaseClient
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var Client
     */
    public $client;

    /**
     * Constructor.
     *
     * @param string $baseUrl        Base URL to the server
     * @param float  $timeout        Timeout of the request in seconds. Use 0 to wait indefinitely
     * @param float  $connectTimeout Number of seconds to wait while trying to connect to a server
     */
    public function __construct($baseUrl, $timeout, $connectTimeout)
    {
        $this->baseUrl = $baseUrl;
        $this->client = new Client([
            'base_url' => $this->baseUrl,
            'defaults' => [
                'timeout' => $timeout,
                'connect_timeout' => $connectTimeout
            ]
        ]);
    }

    /**
     * Get the status of the Event Server or Engine Instance
     *
     * @return string status
     */
    public function getStatus()
    {
        return $this->client->get('/')->getBody();
    }

    /**
     * Send a HTTP request to the server
     *
     * @param string $method HTTP request method
     * @param string $url    Relative or absolute url
     * @param string $body   HTTP request body
     *
     * @return array JSON response
     * @throws PredictionIOAPIError Request error
     */
    protected function sendRequest($method, $url, $body)
    {
        $options = [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $body
        ];

        try {
            $response = $this->client->send($this->client->createRequest($method, $url, $options));
        } catch (ClientException $e) {
            throw new PredictionIOAPIError($e->getMessage());
        }

        return $response->json();
    }
}
