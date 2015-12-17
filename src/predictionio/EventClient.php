<?php

namespace predictionio;

use \DateTime;

/**
 * Client for connecting to an Event Server
 *
 * @package predictionio
 */
class EventClient extends BaseClient
{
    const DATE_TIME_FORMAT = DateTime::ISO8601;

    /**
     * @var string
     */
    private $accessKey;

    /**
     * @var string
     */
    private $eventUrl;

    /**
     * Constructor.
     *
     * @param string $accessKey      Access Key
     * @param string $baseUrl        Base URL to the Event Server. Default is localhost:7070.
     * @param float  $timeout        Timeout of the request in seconds. Use 0 to wait indefinitely. Default is 0.
     * @param float  $connectTimeout Number of seconds to wait while trying to connect to a server. Default is 5.
     */
    public function __construct($accessKey, $baseUrl = 'http://localhost:7070', $timeout = 0, $connectTimeout = 5)
    {
        parent::__construct($baseUrl, $timeout, $connectTimeout);
        $this->accessKey = $accessKey;
        $this->eventUrl = '/events.json?accessKey='.$this->accessKey;
    }

    /**
     * Set a user entity
     *
     * @param int|string $uid        User Id
     * @param array      $properties Properties of the user entity to set
     * @param string     $eventTime  Time of the event in ISO 8601(2014-09-09T16:17:42.937-08:00). Default is the current time.
     *
     * @return string JSON response
     *
     * @throws PredictionIOAPIError Request error
     */
    public function setUser($uid, array $properties = array(), $eventTime = null)
    {
        // casting to object so that an empty array would be represented as {}
        if (empty($properties)) {
            $properties = (object) $properties;
        }

        return $this->sendRequest('POST', $this->eventUrl, json_encode([
            'event' => '$set',
            'entityType' => 'user',
            'entityId' => $uid,
            'properties' => $properties,
            'eventTime' => $this->getEventTime($eventTime),
        ]));
    }

    /**
     * Unset a user entity
     *
     * @param int|string $uid        User Id
     * @param array      $properties Properties of the user entity to unset
     * @param string     $eventTime  Time of the event in ISO 8601(2014-09-09T16:17:42.937-08:00). Default is the current time.
     *
     * @return string JSON response
     *
     * @throws PredictionIOAPIError Request error
     */
    public function unsetUser($uid, array $properties, $eventTime = null)
    {
        if (empty($properties)) {
            throw new PredictionIOAPIError('Specify at least one property');
        }

        return $this->sendRequest('POST', $this->eventUrl, json_encode([
            'event' => '$unset',
            'entityType' => 'user',
            'entityId' => $uid,
            'properties' => $properties,
            'eventTime' => $this->getEventTime($eventTime),
        ]));
    }

    /**
     * Delete a user entity
     *
     * @param int|string $uid        User Id
     * @param string     $eventTime  Time of the event in ISO 8601(2014-09-09T16:17:42.937-08:00). Default is the current time.
     *
     * @return string JSON response
     *
     * @throws PredictionIOAPIError Request error
     */
    public function deleteUser($uid, $eventTime = null)
    {
        return $this->sendRequest('POST', $this->eventUrl, json_encode([
            'event' => '$delete',
            'entityType' => 'user',
            'entityId' => $uid,
            'eventTime' => $this->getEventTime($eventTime),
        ]));
    }

    /**
     * Set an item entity
     *
     * @param int|string $iid        Item Id
     * @param array      $properties Properties of the item entity to set
     * @param string     $eventTime  Time of the event in ISO 8601(2014-09-09T16:17:42.937-08:00). Default is the current time.
     *
     * @return string JSON response
     *
     * @throws PredictionIOAPIError Request error
     */
    public function setItem($iid, array $properties = array(), $eventTime = null)
    {
        if (empty($properties)) {
            $properties = (object)$properties;
        }

        return $this->sendRequest('POST', $this->eventUrl, json_encode([
            'event' => '$set',
            'entityType' => 'item',
            'entityId' => $iid,
            'properties' => $properties,
            'eventTime' => $this->getEventTime($eventTime),
        ]));
    }

    /**
     * Unset an item entity
     *
     * @param int|string $iid        Item Id
     * @param array      $properties Properties of the item entity to unset
     * @param string     $eventTime  Time of the event in ISO 8601(2014-09-09T16:17:42.937-08:00). Default is the current time.
     *
     * @return string JSON response
     *
     * @throws PredictionIOAPIError Request error
     */
    public function unsetItem($iid, array $properties, $eventTime = null)
    {
        if (empty($properties)) {
            throw new PredictionIOAPIError('Specify at least one property');
        }

        return $this->sendRequest('POST', $this->eventUrl, json_encode([
            'event' => '$unset',
            'entityType' => 'item',
            'entityId' => $iid,
            'properties' => $properties,
            'eventTime' => $this->getEventTime($eventTime),
        ]));
    }

    /**
     * Delete an item entity
     *
     * @param int|string $iid       Item Id
     * @param string     $eventTime Time of the event in ISO 8601(2014-09-09T16:17:42.937-08:00). Default is the current time.
     *
     * @return string JSON response
     *
     * @throws PredictionIOAPIError Request error
     */
    public function deleteItem($iid, $eventTime = null)
    {
        return $this->sendRequest('POST', $this->eventUrl, json_encode([
            'event' => '$delete',
            'entityType' => 'item',
            'entityId' => $iid,
            'eventTime' => $this->getEventTime($eventTime),
        ]));
    }

    /**
     * Record a user action on an item
     *
     * @param string     $event      Event name
     * @param int|string $uid        User Id
     * @param int|string $iid        Item Id
     * @param array      $properties Properties of the event
     * @param string     $eventTime  Time of the event in ISO 8601(2014-09-09T16:17:42.937-08:00). Default is the current time.
     *
     * @return string JSON response
     *
     * @throws PredictionIOAPIError Request error
     */
    public function recordUserActionOnItem($event, $uid, $iid, array $properties = array(), $eventTime = null)
    {
        if (empty($properties)) {
            $properties = (object)$properties;
        }

        return $this->sendRequest('POST', $this->eventUrl, json_encode([
            'event' => $event,
            'entityType' => 'user',
            'entityId' => $uid,
            'targetEntityType' => 'item',
            'targetEntityId' => $iid,
            'properties' => $properties,
            'eventTime' => $this->getEventTime($eventTime),
        ]));
    }

    /**
     * Create an event
     *
     * @param array $data An array describing the event
     *
     * @return string JSON response
     *
     * @throws PredictionIOAPIError Request error
     */
    public function createEvent(array $data)
    {
        return $this->sendRequest('POST', $this->eventUrl, json_encode($data));
    }

    /**
     * Retrieve an event
     *
     * @param string $eventId Event ID
     *
     * @return string JSON response
     *
     * @throws PredictionIOAPIError Request error
     */
    public function getEvent($eventId)
    {
        return $this->sendRequest('GET', '/events/'.$eventId.'.json?accessKey='.$this->accessKey, '');
    }

    /**
     * Get Event Time
     *
     * @param $eventTime
     *
     * @return string
     */
    private function getEventTime($eventTime = null)
    {
        if (is_null($eventTime)) {
            $eventTime = (new DateTime('NOW'))->format(self::DATE_TIME_FORMAT);
        }

        return $eventTime;
    }
}
