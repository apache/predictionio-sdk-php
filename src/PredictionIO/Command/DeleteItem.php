<?php

namespace PredictionIO\Command;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;

/**
 * Delete Item Information
 *
 * Delete the information record of an item.
 *
 * @guzzle iid type="string" required="true"
 */
class DeleteItem extends AbstractCommand
{
    /**
     * Set the "iid" parameter for the current command
     *
     * @param string $iid Item ID
     *
     * @return DeleteItem
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
        $this->request = $this->client->createRequest(RequestInterface::DELETE, 'items/' . $this->get('pio_iid'));
    }
}
