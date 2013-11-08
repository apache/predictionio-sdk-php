<?php

namespace PredictionIO\Command;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;

/**
 * Record an action on an item by a user
 *
 * @guzzle action type="string" required="true"
 * @guzzle iid type="string" required="true"
 * @guzzle price type="float"
 * @guzzle t type="string"
 * @guzzle latlng type="string"
 */
class RecordActionOnItem extends AbstractCommand
{
    /**
     * Set the "action" parameter for the current command
     *
     * @param string $action Action name
     *
     * @return RecordActionOnItem
     */
    public function setAction($action)
    {
        return $this->set('pio_action', $action);
    }

    /**
     * Set the "iid" parameter for the current command
     *
     * @param string $iid Item ID
     *
     * @return RecordActionOnItem
     */
    public function setIid($iid)
    {
        return $this->set('pio_iid', $iid);
    }

    /**
     * Set the "t" parameter for the current command
     *
     * @param string $t Time
     *
     * @return RecordActionOnItem
     */
    public function setT($t)
    {
        return $this->set('pio_t', $t * 1000);
    }

    /**
     * Set the "latlng" parameter for the current command
     *
     * In "latitude,longitude" format, e.g. "20.17,114.08"
     *
     * @param string $lat Latitude
     * @param string $lng Longitude
     *
     * @return RecordActionOnItem
     */
    public function setLatlng($lat, $lng = null)
    {
        if (null === $lng) {
            return $this->set("pio_latlng", $lat);
        }

        return $this->set("pio_latlng", sprintf("%s,%s", $lat, $lng));
    }

    /**
     * Create the request object that will carry out the command. Used internally by Guzzle.
     */
    protected function build()
    {
        $this->set('pio_uid', $this->client->getIdentity());
        $this->request = $this->client->createRequest(RequestInterface::POST, 'actions/u2i', null, $this->getAll());
    }
}
