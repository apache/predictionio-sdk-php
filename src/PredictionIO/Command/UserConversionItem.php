<?php

namespace PredictionIO\Command;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;

/**
 * Add Conversion
 *
 * A user performs an action that completes an activity that is beneficial to your business success
 *
 * @guzzle uid type="string" required="true"
 * @guzzle iid type="string" required="true"
 * @guzzle price type="float"
 * @guzzle t type="string"
 * @guzzle latlng type="string"
 */
class UserConversionItem extends UserActionItem
{
  /**
   * Set the "price" parameter for the current command
   *
   * @param float $price Price
   *
   * @return UserConversionItem
   */
  public function setPrice($price)
  {
    return $this->set('price', $price);
  }

  /**
   * Create the request object that will carry out the command. Used internally by Guzzle.
   */
  protected function build()
  {
    $this->request = $this->client->createRequest(RequestInterface::POST, 'actions/u2i/conversion', null, $this->getAll());
  }
}

?>