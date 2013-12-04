<?php

namespace PredictionIO\Command;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\AbstractCommand;

/**
 * Create Item Information
 *
 * Create or re-create an information record for a item. Re-creation will remove all data of the current record.
 *
 * To supply custom item information, simply pass it in during command creation,
 * or use the "set" method inherited from Guzzle\Common\Collection.
 * <code>
 * $command = $client->getCommand('create_item', array('pio_iid' => 'foobar', 'custom1' => 'baz'));
 * $command->set('custom2', '0xdeadbeef');
 * </code>
 *
 * @guzzle iid type="string" required="true"
 * @guzzle itypes type="string" required="true"
 * @guzzle startT type="string"
 * @guzzle endT type="string"
 * @guzzle price type="float"
 * @guzzle profit type="float"
 * @guzzle latlng type="string"
 * @guzzle inactive type="boolean"
 */
class CreateItem extends AbstractCommand
{
    /**
     * Set the "iid" parameter for the current command
     *
     * @param string $iid Item ID
     *
     * @return CreateItem
     */
    public function setIid($iid)
    {
        return $this->set("pio_iid", $iid);
    }

    /**
     * Set the "itypes" parameter for the current command
     *
     * $itypes can be supplied as an array of strings, or a "," delimited list of strings.
     *
     * @param array|string $itypes Item types
     *
     * @return CreateItem
     */
    public function setItypes($itypes)
    {
        if (is_array($itypes)) {
            return $this->set("pio_itypes", implode(",", $itypes));
        }

        return $this->set("pio_itypes", $itypes);
    }

    /**
     * Set the "startT" parameter for the current command
     *
     * @param string $startT Start time
     *
     * @return CreateItem
     */
    public function setStartT($startT)
    {
        return $this->set("pio_startT", $startT);
    }

    /**
     * Set the "endT" parameter for the current command
     *
     * @param string $endT End time
     *
     * @return CreateItem
     */
    public function setEndT($endT)
    {
        return $this->set("pio_endT", $endT);
    }

    /**
     * Set the "price" parameter for the current command
     *
     * @param float $price Price
     *
     * @return CreateItem
     */
    public function setPrice($price)
    {
        return $this->set("pio_price", $price);
    }

    /**
     * Set the "profit" parameter for the current command
     *
     * @param float $profit Profit
     *
     * @return CreateItem
     */
    public function setProfit($profit)
    {
        return $this->set("pio_profit", $profit);
    }

    /**
     * Set the "latlng" parameter for the current command
     *
     * In "latitude,longitude" format, e.g. "20.17,114.08"
     *
     * @param string $lat Latitude
     * @param string $lng Longitude
     *
     * @return CreateItem
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
     * @param string $inactive Inactive flag (use "true" or "false" string)
     *
     * @return CreateItem
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
        $this->request = $this->client->createRequest(RequestInterface::POST, 'items', null, $this->getAll());
    }
}
