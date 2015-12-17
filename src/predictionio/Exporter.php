<?php

namespace predictionio;

/**
 * Trait Exporter
 *
 * @package predictionio
 */
trait Exporter
{
    /**
     * @param $json
     *
     * @return mixed
     */
    abstract public function export($json);

    /**
     * Json Encode
     *
     * @param mixed $data
     *
     * @return string
     */
    public function jsonEncode($data)
    {
        return json_encode($data);
    }

    /**
     * Create and export a json-encoded event.
     *
     * @see \predictionio\EventClient::CreateEvent()
     *
     * @param string $event
     * @param string $entityType
     * @param int    $entityId
     * @param string $targetEntityType
     * @param string $targetEntityId
     * @param array  $properties
     * @param string $eventTime
     */
    public function createEvent($event, $entityType, $entityId, $targetEntityType = null, $targetEntityId = null,
        array $properties = null, $eventTime = null)
    {

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

        $this->export($this->jsonEncode($data));
    }
}
