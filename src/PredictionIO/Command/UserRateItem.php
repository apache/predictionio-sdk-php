<?php

namespace PredictionIO\Command;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;

/**
 * Add Rating
 *
 * A user rates an item
 *
 * @guzzle uid type="string" required="true"
 * @guzzle iid type="string" required="true"
 * @guzzle rate type="integer" required="true"
 * @guzzle t type="string"
 * @guzzle latlng type="string"
 */
class UserRateItem extends UserActionItem
{
  /**
   * Set the "rate" parameter for the current command
   *
   * @param integer $rate Rating
   *
   * @return UserRateItem
   */
  public function setRate($rate)
  {
    return $this->set('rate', $rate);
  }

  /**
   * Create the request object that will carry out the command. Used internally by Guzzle.
   */
  protected function build()
  {
    $this->request = $this->client->createRequest(RequestInterface::POST, 'actions/u2i/rate', null, $this->getAll());
  }
}

?>