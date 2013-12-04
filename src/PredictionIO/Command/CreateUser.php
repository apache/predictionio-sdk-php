<?php

namespace PredictionIO\Command;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;

/**
 * Create User Information
 *
 * Create or re-create an information record for a user. Re-creation will remove all data of the current record.
 *
 * To supply custom user information, simply pass it in during command creation,
 * or use the "set" method inherited from Guzzle\Common\Collection.
 * <code>
 * $command = $client->getCommand('create_user', array('pio_uid' => 'foobar', 'custom1' => 'baz'));
 * $command->set('custom2', '0xdeadbeef');
 * </code>
 *
 * @guzzle uid type="string" required="true"
 * @guzzle latlng type="string"
 * @guzzle inactive type="boolean"
 */
class CreateUser extends AbstractCommand
{
    /**
     * Set the "uid" parameter for the current command
     *
     * @param string $uid User ID
     *
     * @return CreateUser
     */
    public function setUid($uid)
    {
        return $this->set("pio_uid", $uid);
    }

    /**
     * Set the "latlng" parameter for the current command
     *
     * In "latitude,longitude" format, e.g. "20.17,114.08"
     *
     * @param string $lat Latitude
     * @param string $lng Longitude
     *
     * @return CreateUser
     */
    public function setLatlng($lat, $lng = null)
    {
        if (null === $lng) {
            return $this->set("pio_latlng", $lat);
        }

        return $this->set("pio_latlng", sprintf("%s,%s", $lat, $lng));
    }

    /**
     * Set the "inactive" parameter for the current command
     *
     * @param bool $inactive Inactive flag (use "true" or "false" string)
     *
     * @return CreateUser
     */
    public function setInactive($inactive)
    {
        return $this->set("pio_inactive", $inactive);
    }

    /**
     * Create the request object that will carry out the command. Used internally by Guzzle.
     */
    protected function build()
    {
        $this->request = $this->client->createRequest(RequestInterface::POST, 'users', null, $this->getAll());
    }
}
