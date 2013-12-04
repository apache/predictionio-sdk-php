<?php

namespace PredictionIO\Command;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;

/**
 * Retrieve Item Information
 *
 * Get the information record of an item.
 * If startT/endT exists, it will be returned in UNIX UTC timestamp (milliseconds) format.
 *
 * @guzzle iid type="string" required="true"
 */
class GetItem extends AbstractCommand
{
    /**
     * Set the "iid" parameter for the current command
     *
     * @param string $iid Item ID
     *
     * @return GetItem
     */
    public function setIid($iid)
    {
        return $this->set('pio_iid', $iid);
    }

    /**
     * Create the request object that will carry out the command. Used internally by Guzzle.
     */
    protected function build()
    {
        $this->request = $this->client->createRequest(RequestInterface::GET, 'items/' . $this->get('pio_iid'));
    }
}
