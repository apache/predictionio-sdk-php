PredictionIO PHP SDK
====================

Prerequisites
-------------

* PHP 5.3+ (http://php.net/)
* PHP: cURL (http://php.net/manual/en/book.curl.php)
* Phing (http://www.phing.info/)
* ApiGen (http://apigen.org/)

Getting Started
---------------

### By Composer

The easiest way to install PredictionIO PHP client is to use [Composer](http://getcomposer.org/).

1. Add `predictionio/predictionio` as a dependency in your project's ``composer.json`` file:

        {
            "require": {
                "predictionio/predictionio": "*"
            }
        }

2. Install Composer:

        curl -sS https://getcomposer.org/installer | php

3. Use Composer to install your dependencies:

        php composer.phar install

4. Require Composer's autoloader

        require_once("vendor/autoload.php");


### By Building Phar

1. Assuming you are cloning to your home directory:

        cd ~
        git clone git://github.com/PredictionIO/PredictionIO-PHP-SDK.git

2. Build the Phar:

        cd ~/PredictionIO-PHP-SDK
        phing

3. Once the build finishes you will get a Phar in `build/artifacts`, and a set of API documentation.
   Assuming you have copied the Phar to your current working directory, to use the client, simply

        require_once("predictionio.phar");


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
