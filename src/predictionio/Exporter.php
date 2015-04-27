<?php

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