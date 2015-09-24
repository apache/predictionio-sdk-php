<?php

namespace predictionio;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Base client for Event and Engine client
 *
 */
abstract class BaseClient {
  private $baseUrl;
  public $client;

  /**
   * @param string $baseUrl Base URL to the server
   * @param float $timeout Timeout of the request in seconds. Use 0 to wait indefinitely
   * @param float $connectTimeout Number of seconds to wait while trying to connect to a server
   */  
  public function __construct($baseUrl, $timeout, $connectTimeout) {
    $this->baseUrl = $baseUrl;
    $this->client = new Client([
           'base_uri' => $this->baseUrl,
           'timeout' => $timeout,
           'connect_timeout' => $connectTimeout
    ]);

  }

  /**
   * Get the status of the Event Server or Engine Instance
   *
   * @return string status
   */
  public function getStatus() {
    return $this->client->get('/')->getBody();
  }

  /**
   * Send a HTTP request to the server
   *
   * @param string $method HTTP request method
   * @param string $url Relative or absolute url
   * @param string $body HTTP request body
   * @param boolean $async Send request asynchronously and return a promise
   * @return array|PromiseInterface JSON response
   * @throws PredictionIOAPIError
   */
  protected function sendRequest($method, $url, $body, $async = false) {
    $options = ['headers' => ['Content-Type' => 'application/json'],
                'body' => $body]; 

    try {
      if ($async) {
        return $this->client->requestAsync($method, $url, $options);
      } else {
        $response = $this->client->request($method, $url, $options);
        return json_decode($response->getBody(), true);
      }
    } catch (ClientException $e) {
      throw new PredictionIOAPIError($e->getMessage()); 
    }
  }
}
?>
