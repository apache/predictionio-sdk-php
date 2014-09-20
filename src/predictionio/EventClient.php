<?php

namespace predictionio;
use GuzzleHttp\Client;
use \DateTime;
 
/**
 * Client for connecting to an Event Server
 *
 */
class EventClient extends BaseClient {
  const DATE_TIME_FORMAT = DateTime::ISO8601;
  private $appId;

  /**
   * @param string Base URL to the Event Server. Default is localhost:7070.
   * @param float Timeout of the request in seconds. Use 0 to wait indefinitely
   *              Default is 0.
   * @param float Number of seconds to wait while trying to connect to a server.
   *              Default is 5.                
   */
  public function __construct($appId, $baseUrl='http://localhost:7070',
                              $timeout=0, $connectTimeout=5 ) {
    parent::__construct($baseUrl, $timeout, $connectTimeout);
    $this->appId = $appId;
  }

  private function getEventTime($eventTime) {
    $result = $eventTime;
    if (!isset($eventTime)) {
      $result = (new DateTime('NOW'))->format(self::DATE_TIME_FORMAT);
    } 

    return $result;
  }

  /**
   * Set a user entity
   *
   * @param int|string User Id 
   * @param array Properties of the user entity to set
   * @param string Time of the event in ISO 8601 format
   *               (e.g. 2014-09-09T16:17:42.937-08:00).
   *               Default is the current time.
   *
   * @return string JSON response
   * 
   * @throws PredictionIOAPIError Request error
   */
  public function setUser($uid, array $properties=array(), $eventTime=null) {
    $eventTime = $this->getEventTime($eventTime);

    // casting to object so that an empty array would be represented as {}
    if (empty($properties)) $properties = (object)$properties;

    $json = json_encode([
        'event' => '$set',
        'entityType' => 'pio_user',
        'entityId' => $uid,
        'appId' => $this->appId,
        'properties' => $properties,
        'eventTime' => $eventTime,
    ]);

    return $this->sendRequest('POST', '/events.json', $json);
  }

  /**
   * Unset a user entity
   *
   * @param int|string User Id 
   * @param array Properties of the user entity to unset
   * @param string Time of the event in ISO 8601 format
   *               (e.g. 2014-09-09T16:17:42.937-08:00).
   *               Default is the current time.
   *
   * @return string JSON response
   * 
   * @throws PredictionIOAPIError Request error
   */
  public function unsetUser($uid, array $properties, $eventTime=null) {
    $eventTime = $this->getEventTime($eventTime);
    if (empty($properties)) 
      throw new PredictionIOAPIError('Specify at least one property'); 

    $json = json_encode([
        'event' => '$unset',
        'entityType' => 'pio_user',
        'entityId' => $uid,
        'appId' => $this->appId,
        'properties' => $properties,
        'eventTime' => $eventTime,
    ]);

    return $this->sendRequest('POST', '/events.json', $json);
  }

  /**
   * Delete a user entity
   *
   * @param int|string User Id 
   * @param string Time of the event in ISO 8601 format
   *               (e.g. 2014-09-09T16:17:42.937-08:00).
   *               Default is the current time.
   *
   * @return string JSON response
   * 
   * @throws PredictionIOAPIError Request error
   */
  public function deleteUser($uid, $eventTime=null) {
    $eventTime = $this->getEventTime($eventTime);

    $json = json_encode([
        'event' => '$delete',
        'entityType' => 'pio_user',
        'entityId' => $uid,
        'appId' => $this->appId,
        'eventTime' => $eventTime,
    ]);

    return $this->sendRequest('POST', '/events.json', $json);
  }
 
  /**
   * Set an item entity
   *
   * @param int|string Item Id 
   * @param array Properties of the item entity to set
   * @param string Time of the event in ISO 8601 format
   *               (e.g. 2014-09-09T16:17:42.937-08:00).
   *               Default is the current time.
   *
   * @return string JSON response
   * 
   * @throws PredictionIOAPIError Request error
   */
   public function setItem($iid, array $properties=array(), $eventTime=null) {
    $eventTime = $this->getEventTime($eventTime);
    if (empty($properties)) $properties = (object)$properties;
    $json = json_encode([
        'event' => '$set',
        'entityType' => 'pio_item',
        'entityId' => $iid,
        'appId' => $this->appId,
        'properties' => $properties,
        'eventTime' => $eventTime,
    ]);

    return $this->sendRequest('POST', '/events.json', $json);
  }

  /**
   * Unset an item entity
   *
   * @param int|string Item Id 
   * @param array Properties of the item entity to unset
   * @param string Time of the event in ISO 8601 format
   *               (e.g. 2014-09-09T16:17:42.937-08:00).
   *               Default is the current time.
   *
   * @return string JSON response
   * 
   * @throws PredictionIOAPIError Request error
   */
  public function unsetItem($iid, array $properties, $eventTime=null) {
    $eventTime = $this->getEventTime($eventTime);
    if (empty($properties))
        throw new PredictionIOAPIError('Specify at least one property'); 
    $json = json_encode([
        'event' => '$unset',
        'entityType' => 'pio_item',
        'entityId' => $iid,
        'appId' => $this->appId,
        'properties' => $properties,
        'eventTime' => $eventTime,
    ]);

    return $this->sendRequest('POST', '/events.json', $json);
  }

  /**
   * Delete an item entity
   *
   * @param int|string Item Id 
   * @param string Time of the event in ISO 8601 format
   *               (e.g. 2014-09-09T16:17:42.937-08:00).
   *               Default is the current time.
   *
   * @return string JSON response
   * 
   * @throws PredictionIOAPIError Request error
   */
  public function deleteItem($iid, $eventTime=null) {
    $eventTime = $this->getEventTime($eventTime);

    $json = json_encode([
        'event' => '$delete',
        'entityType' => 'pio_item',
        'entityId' => $iid,
        'appId' => $this->appId,
        'eventTime' => $eventTime,
    ]);

    return $this->sendRequest('POST', '/events.json', $json);
  }

  /**
   * Record a user action on an item
   *
   * @param string Event name
   * @param int|string User Id 
   * @param int|string Item Id 
   * @param array Properties of the event
   * @param string Time of the event in ISO 8601 format
   *               (e.g. 2014-09-09T16:17:42.937-08:00).
   *               Default is the current time.
   *
   * @return string JSON response
   * 
   * @throws PredictionIOAPIError Request error
   */
   public function recordUserActionOnItem($event, $uid, $iid, 
                                         array $properties=array(),
                                         $eventTime=null) {
    $eventTime = $this->getEventTime($eventTime);
    if (empty($properties)) $properties = (object)$properties;
    $json = json_encode([
        'event' => $event,
        'entityType' => 'pio_user',
        'entityId' => $uid,
        'targetEntityType' => 'pio_item',
        'targetEntityId' => $iid,
        'appId' => $this->appId,
        'properties' => $properties,
        'eventTime' => $eventTime,
    ]);

    return $this->sendRequest('POST', '/events.json', $json);
  }

  /**
   * Create an event
   *
   * @param array An array describing the event
   *
   * @return string JSON response
   * 
   * @throws PredictionIOAPIError Request error
   */
  public function createEvent(array $data) {
    $json = json_encode($data);

    return $this->sendRequest('POST', '/events.json', $json);
  }

  /**
   * Retrieve an event
   *
   * @param string Event ID
   *
   * @return string JSON response
   * 
   * @throws PredictionIOAPIError Request error
   */
  public function getEvent($eventId) {
    return $this->sendRequest('GET', "/events/$eventId.json", '');
  }
}

?>
