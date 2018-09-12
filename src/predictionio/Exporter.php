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


trait Exporter {

    abstract public function export($json);

    public function jsonEncode($data) {
        return json_encode($data);
    }

    /**
     * Create and export a json-encoded event.
     *
     * @see \predictionio\EventClient::CreateEvent()
     *
     * @param $event
     * @param $entityType
     * @param $entityId
     * @param null $targetEntityType
     * @param null $targetEntityId
     * @param array $properties
     * @param $eventTime
     */
    public function createEvent($event, $entityType, $entityId,
                                $targetEntityType=null, $targetEntityId=null, array $properties=null,
                                $eventTime=null) {

        if (!isset($eventTime)) {
            $eventTime = new \DateTime();
        } elseif (!($eventTime instanceof \DateTime)) {
            $eventTime = new \DateTime($eventTime);
        }
        $eventTime = $eventTime->format(\DateTime::ISO8601);

        $data = [
            'event' => $event,
            'entityType' => $entityType,
            'entityId' => $entityId,
            'eventTime' => $eventTime,
        ];

        if (isset($targetEntityType)) {
            $data['targetEntityType'] = $targetEntityType;
        }

        if (isset($targetEntityId)) {
            $data['targetEntityId'] = $targetEntityId;
        }

        if (isset($properties)) {
            $data['properties'] = $properties;
        }

        $json = $this->jsonEncode($data);

        $this->export($json);
    }

}
