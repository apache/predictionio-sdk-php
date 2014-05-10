<?php

namespace PredictionIO\Command;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;

/**
 * ItemRank Engine Get Items Ranking for a User
 *
 * Retrieve ranking of items for this specific user.
 *
 * @guzzle engine type="string" required="true"
 * @guzzle iids type="string" required="true"
 */
class ItemrankGetRanked extends AbstractCommand
{
    /**
     * Set the "engine" parameter for the current command
     *
     * @param string $engine Engine Name
     *
     * @return ItemrankGetRanked
     */
    public function setEngine($engine)
    {
        return $this->set('pio_engine', $engine);
    }

    /**
     * Set the "iids" parameter for the current command
     *
     * @param string $iids Comma-separated list of Item IDs
     *
     * @return ItemrankGetRanked
     */
    public function setIids($iids)
    {
        return $this->set('pio_iids', $iids);
    }

    /**
     * Create the request object that will carry out the command. Used internally by Guzzle.
     */
    protected function build()
    {
        $this->set('pio_uid', $this->client->getIdentity());
        $this->request = $this->client->createRequest(
            RequestInterface::GET,
            'engines/itemrank/' . $this->get('pio_engine') . '/ranked',
            null,
            $this->getAll()
        );
    }
}
