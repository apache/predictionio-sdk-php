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
   *
   * @return array JSON response
   * @throws PredictionIOAPIError Request error
   */
  protected function sendRequest($method, $url, $body) {
    $options = [
      'headers' => [
        'Accept-Encoding' => 'gzip',
        'Content-Type' => 'application/json',
      ],
      'body' => $body,
    ];

    try {
      $response = $this->client->request($method, $url, $options);
      return json_decode($response->getBody(), true);
    } catch (ClientException $e) {
      throw new PredictionIOAPIError($e->getMessage());
    }
  }
}
?>
