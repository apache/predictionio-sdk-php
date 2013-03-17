<?php

namespace PredictionIO\Command;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;

/**
 * Parent class of User<Action>Item classes
 *
 * Do not use this directly. Use its subclasses.
 */
class UserActionItem extends AbstractCommand
{
  /**
   * Set the "uid" parameter for the current command
   *
   * @param string $uid User ID
   *
   * @return UserActionItem
   */
  public function setUid($uid)
  {
    return $this->set('uid', $uid);
  }

  /**
   * Set the "iid" parameter for the current command
   *
   * @param string $iid Item ID
   *
   * @return UserActionItem
   */
  public function setIid($iid)
  {
    return $this->set('iid', $iid);
  }

  /**
   * Set the "t" parameter for the current command
   *
   * @param string $t Time
   *
   * @return UserActionItem
   */
  public function setT($t)
  {
    return $this->set('t', $t*1000);
  }

  /**
   * Set the "latlng" parameter for the current command
   *
   * In "latitude,longitude" format, e.g. "20.17,114.08"
   *
   * @param string $latlng Latitude and longitude
   *
   * @return UserActionItem
   */
  public function setLatlng($latlng)
  {
    return $this->set('latlng', $latlng);
  }

  /**
   * Actual implementation in subclasses
   */
  protected function build()
  {
  }
}

?>