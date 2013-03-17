PredictionIO PHP SDK
====================

Prerequisites
-------------

* PHP 5.3+ (http://php.net/)
* PHP: cURL (http://php.net/manual/en/book.curl.php)
* Phing (http://www.phing.info/)
* ApiGen (http://apigen.org/)

Building
--------

Assuming you are cloning to your home directory.

    cd ~
    git clone git://github.com/PredictionIO/PredictionIO-PHP-SDK.git

To build the SDK,

    cd ~/PredictionIO-PHP-SDK
    phing

Once the build finish you will get a Phar and a set of API documentation.

Supported Commands
------------------

For a list of supported commands, please refer to the API documentation.

Usage
-----

This package is a web service client based on Guzzle.
A few quick examples are shown below.

For a full user guide on how to take advantage of all Guzzle features, please refer to http://guzzlephp.org.
Specifically, http://guzzlephp.org/tour/using_services.html#using-client-objects describes how to use a web service client.

Many REST request commands support optional arguments.
They can be supplied to these commands by the `set` method.

### Instantiate PredictionIO API Client

    require_once("predictionio.phar");
    use PredictionIO\PredictionIOClient;
    $client = PredictionIOClient::factory(array("appkey" => "<your app key>"));

### Import a User Record from Your App

    // (your user registration logic)
    $uid = get_user_from_your_db();
    $command = $client->getCommand('create_user', array('uid' => $uid));
    $response = $client->execute($command);
    // (other work to do for the rest of the page)

### Import a User Action (View) form Your App

    $client->execute($client->getCommand('user_view_item', array('uid' => '4', 'iid' => '15')));
    // (other work to do for the rest of the page)

### Retrieving Top N Recommendations for a User

    $client->execute($client->getCommand('itemrec_get_top_n', array('engine' => 'test', 'uid' => '4', 'n' => 10)));
    // (work you need to do for the page (rendering, db queries, etc))
