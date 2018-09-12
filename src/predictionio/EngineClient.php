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

/**
 * Client for connecting to an Engine Instance
 *
 */
class EngineClient extends BaseClient {

  /**
   * @param string Base URL to the Engine Instance. Default is localhost:8000.
   * @param float Timeout of the request in seconds. Use 0 to wait indefinitely
   *              Default is 0.
   * @param float Number of seconds to wait while trying to connect to a server.
   *              Default is 5.
   */
  public function __construct($baseUrl="http://localhost:8000",
                              $timeout=0, $connectTimeout=5 ) {
    parent::__construct($baseUrl, $timeout, $connectTimeout);
  }

  /**
   * Send prediction query to an Engine Instance
   *
   * @param array Query
   *
   * @return array JSON response
   *
   * @throws PredictionIOAPIError Request error
   */
  public function sendQuery(array $query) {
    return $this->sendRequest("POST", "/queries.json", json_encode($query));
  }
}

?>
