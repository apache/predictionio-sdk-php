<?php

namespace PredictionIO\Command;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;

/**
 * ItemRec Engine Get Top N Recommendations for a User
 *
 * Retrieve top N recommended items for this specific user.
 *
 * @guzzle engine type="string" required="true"
 * @guzzle uid type="string" required="true"
 * @guzzle n type="integer" required="true"
 * @guzzle itypes type="string"
 * @guzzle latlng type="string"
 * @guzzle within type="float"
 * @guzzle unit type="enum:km,mi"
 */
class ItemrecGetTopN extends AbstractCommand
{
  /**
   * Set the "engine" parameter for the current command
   *
   * @param string $engine Engine Name
   *
   * @return ItemrecGetTopN
   */
  public function setEngine($engine)
  {
    return $this->set('engine', $engine);
  }

  /**
   * Set the "uid" parameter for the current command
   *
   * @param string $uid User ID
   *
   * @return ItemrecGetTopN
   */
  public function setUid($uid)
  {
    return $this->set('uid', $uid);
  }

  /**
   * Set the "n" parameter for the current command
   *
   * @param integer $n N
   *
   * @return ItemrecGetTopN
   */
  public function setN($n)
  {
    return $this->set('n', $n);
  }

  /**
   * Set the "itypes" parameter for the current command
   *
   * $itypes can be supplied as an array of integers, or a "," delimited list of integers.
   *
   * @param array|string $itypes Item types
   *
   * @return ItemrecGetTopN
   */
  public function setItypes($itypes)
  {
    if (is_array($itypes)) {
      return $this->set('itypes', implode(',', $itypes));
    } else {
      return $this->set('itypes', $itypes);
    }
  }

  /**
   * Set the "latlng" parameter for the current command
   *
   * In "latitude,longitude" format, e.g. "20.17,114.08"
   *
   * @param string $latlng Latitude and longitude
   *
   * @return ItemrecGetTopN
   */
  public function setLatlng($latlng)
  {
    return $this->set('latlng', $latlng);
  }

  /**
   * Set the "within" parameter for the current command
   *
   * @param float $within Radius
   *
   * @return ItemrecGetTopN
   */
  public function setWithin($within)
  {
    return $this->set('within', $within);
  }

  /**
   * Set the "unit" parameter for the current command
   *
   * @param string $unit Unit of radius
   *
   * @return ItemrecGetTopN
   */
  public function setUnit($unit)
  {
    return $this->set('unit', $unit);
  }

  /**
   * Create the request object that will carry out the command. Used internally by Guzzle.
   */
  protected function build()
  {
    $this->request = $this->client->createRequest(RequestInterface::GET, 'engines/itemrec/' . $this->get('engine') . '/topn', null, $this->getAll());
  }
}

?>