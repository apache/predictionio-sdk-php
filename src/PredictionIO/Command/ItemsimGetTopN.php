<?php

namespace PredictionIO\Command;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;

/**
 * ItemSim Engine Get Top N Similar Items for an Item
 *
 * Retrieve top N similar items for this specific item.
 *
 * @guzzle engine type="string" required="true"
 * @guzzle iid type="string" required="true"
 * @guzzle n type="integer" required="true"
 * @guzzle itypes type="string"
 * @guzzle latlng type="string"
 * @guzzle within type="float"
 * @guzzle unit type="enum:km,mi"
 */
class ItemsimGetTopN extends AbstractCommand
{
    /**
     * Set the "engine" parameter for the current command
     *
     * @param string $engine Engine Name
     *
     * @return ItemsimGetTopN
     */
    public function setEngine($engine)
    {
        return $this->set('pio_engine', $engine);
    }

    /**
     * Set the "iid" parameter for the current command
     *
     * @param string $iid Item ID
     *
     * @return ItemsimGetTopN
     */
    public function setIid($iid)
    {
        return $this->set('pio_iid', $iid);
    }

    /**
     * Set the "n" parameter for the current command
     *
     * @param integer $n N
     *
     * @return ItemsimGetTopN
     */
    public function setN($n)
    {
        return $this->set('pio_n', $n);
    }

    /**
     * Set the "itypes" parameter for the current command
     *
     * $itypes can be supplied as an array of integers, or a "," delimited list of integers.
     *
     * @param array|string $itypes Item types
     *
     * @return ItemsimGetTopN
     */
    public function setItypes($itypes)
    {
        if (is_array($itypes)) {
            return $this->set('pio_itypes', implode(',', $itypes));
        }

        return $this->set('pio_itypes', $itypes);
    }

    /**
     * Set the "latlng" parameter for the current command
     *
     * In "latitude,longitude" format, e.g. "20.17,114.08"
     *
     * @param string $lat Latitude
     * @param string $lng Longitude
     *
     * @return ItemsimGetTopN
     */
    public function setLatlng($lat,$lng=null)
    {
        if ($lng === null) {
            return $this->set("pio_latlng", $lat);
        } else {
            return $this->set("pio_latlng", sprintf("%s,%s", $lat, $lng));
        }
    }

    /**
     * Set the "within" parameter for the current command
     *
     * @param float $within Radius
     *
     * @return ItemsimGetTopN
     */
    public function setWithin($within)
    {
        return $this->set('pio_within', $within);
    }

    /**
     * Set the "unit" parameter for the current command
     *
     * @param string $unit Unit of radius
     *
     * @return ItemsimGetTopN
     */
    public function setUnit($unit)
    {
        return $this->set('pio_unit', $unit);
    }

    /**
     * Create the request object that will carry out the command. Used internally by Guzzle.
     */
    protected function build()
    {
        $this->request = $this->client->createRequest(
            RequestInterface::GET,
            'engines/itemsim/' . $this->get('pio_engine') . '/topn',
            null,
            $this->getAll()
        );
    }
}
