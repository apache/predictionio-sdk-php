<?php

namespace PredictionIO\Command;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;

/**
 * Delete User Information
 *
 * Delete the information record of a user.
 *
 * @guzzle uid type="string" required="true"
 */
class DeleteUser extends AbstractCommand
{
    /**
     * Set the "uid" parameter for the current command
     *
     * @param string $uid User ID
     *
     * @return DeleteUser
     */
    public function setUid($uid)
    {
        return $this->set('pio_uid', $uid);
    }

    /**
     * Create the request object that will carry out the command. Used internally by Guzzle.
     */
    protected function build()
    {
        $this->request = $this->client->createRequest(RequestInterface::DELETE, 'users/' . $this->get('pio_uid'));
    }
}
