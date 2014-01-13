<?php

namespace PredictionIO;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\EntityBodyInterface;
use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Command\AbstractCommand;

/**
 * PredictionIO API Client
 *
 * This package is a web service client based on Guzzle.
 * A few quick examples are shown below.
 * For a full user guide on how to take advantage of all Guzzle features, please refer to http://guzzlephp.org.
 * Specifically, http://guzzlephp.org/tour/using_services.html#using-client-objects describes
 * how to use a web service client.
 *
 * Many REST request commands support optional arguments. They can be supplied to these commands using the set method.
 *
 * <b>Instantiate PredictionIO API Client</b>
 * <code>
 * require_once("predictionio.phar");
 * use PredictionIO\PredictionIOClient;
 * $client = PredictionIOClient::factory(array("appkey" => "<your app key>"));
 * </code>
 *
 * <b>Import a User Record from Your App</b>
 * <code>
 * // (your user registration logic)
 * $uid = get_user_from_your_db();
 * $command = $client->getCommand('create_user', array('pio_uid' => $uid));
 * $response = $client->execute($command);
 * // (other work to do for the rest of the page)
 * </code>
 *
 * <b>Import a User Action (View) form Your App</b>
 * <code>
 * $client->identify('4');
 * $client->execute($client->getCommand('record_action_on_item', array('pio_action' => 'view', 'pio_iid' => '15')));
 * // (other work to do for the rest of the page)
 * </code>
 *
 * <b>Retrieving Top N Recommendations for a User</b>
 * <code>
 * $client->identify('4');
 * $client->execute($client->getCommand('itemrec_get_top_n', array('pio_engine' => 'test', 'pio_n' => 10)));
 * // (work you need to do for the page (rendering, db queries, etc))
 * </code>
 *
 * @author The PredictionIO Team (http://prediction.io)
 * @copyright 2013 TappingStone Inc.
 */
class PredictionIOClient extends Client
{
    private $apiuid = NULL;

    /**
     * Factory method to create a new PredictionIOClient
     *
     * Configuration data is an array with these keys:
     * * appkey - App key of your PredictionIO app (required)
     * * apiurl - URL of API endpoint (optional)
     *
     * @param array|Collection $config Configuration data.
     *
     * @return PredictionIOClient
     */
    public static function factory($config = array())
    {
        $default = array('apiurl' => 'http://localhost:8000');
        $required = array('appkey');
        $config = Collection::fromConfig($config, $default, $required);

        $client = new self($config->get('apiurl'), $config);

        return $client;
    }

    /**
     * Identify the user ID that will be used by all subsequent
     * recording of actions on items, and recommendations retrieval.
     *
     * @param string $uid User ID.
     */
    public function identify($uid)
    {
        $this->apiuid = $uid;
    }

    /**
     * Returns the identity (user ID) that will be used by all subsequent
     * recording of actions on items, and recommendations retrieval.
     *
     * @return string
     * @throws UnidentifiedUserException
     */
    public function getIdentity()
    {
        if (!isset($this->apiuid)) {
            throw new UnidentifiedUserException("Must call identify() before performing any user-related commands.");
        }

        return $this->apiuid;
    }

    /**
     * Create and return a new RequestInterface configured for the client.
     *
     * Used internally by the library. Do not use directly.
     *
     * @param string                                    $method  HTTP method. Default to GET.
     * @param string|array                              $uri     Resource URI
     * @param array|Collection                          $headers HTTP headers
     * @param string|resource|array|EntityBodyInterface $body    Entity body of request (POST/PUT) or response (GET)
     * @param array                                     $options Array of options to apply to the request
     *
     * @return RequestInterface
     */
    public function createRequest($method = RequestInterface::GET, $uri = null, $headers = null, $body = null, array $options = array())
    {
        if (is_array($body)) {
            $body['pio_appkey'] = $this->getConfig()->get("appkey");
        } else {
            $body = array('pio_appkey' => $this->getConfig()->get("appkey"));
        }

        // Remove Guzzle internals to prevent them from going to the API
        unset($body[AbstractCommand::HEADERS_OPTION]);
        unset($body[AbstractCommand::ON_COMPLETE]);
        unset($body[AbstractCommand::DISABLE_VALIDATION]);
        unset($body[AbstractCommand::RESPONSE_PROCESSING]);
        unset($body[AbstractCommand::RESPONSE_BODY]);

        if ($method == RequestInterface::GET || $method == RequestInterface::DELETE) {
            $request = parent::createRequest($method, $uri, $headers, null, $options);
            $request->getQuery()->replace($body);
        } else {
            $request = parent::createRequest($method, $uri, $headers, $body, $options);
        }
        $request->setPath($request->getPath() . ".json");

        return $request;
    }
}