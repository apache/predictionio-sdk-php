<?php

namespace predictionio;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Base client for Event and Engine client
 *
 */
abstract class BaseClient {
  private $baseUrl;
  public $client;

  /**
   * @param string Base URL to the server
   * @param float Timeout of the request in seconds. Use 0 to wait indefinitely
   * @param float Number of seconds to wait while trying to connect to a server
   */  
  public function __construct($baseUrl, $timeout, $connectTimeout) {
    $this->baseUrl = $baseUrl;
    $this->client = new Client([
           'base_url' => $this->baseUrl,
           'defaults' => ['timeout' => $timeout, 
                          'connect_timeout' => $connectTimeout]
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
   * @param string HTTP request method
   * @param string Relative or absolute url
   * @param string HTTP request body
   *
   * @return array JSON response
   * @throws PredictionIOAPIError Request error
   */
  protected function sendRequest($method, $url, $body) {
    $options = ['headers' => ['Content-Type' => 'application/json'],
                'body' => $body]; 
    $request = $this->client->createRequest($method, $url, $options);

    try {
      $response = $this->client->send($request);
      return $response->json();
    } catch (ClientException $e) {
      throw new PredictionIOAPIError($e->getMessage()); 
    }
  }
}
?>
