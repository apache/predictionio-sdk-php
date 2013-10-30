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
                "predictionio/predictionio": "~0.6.0"
            }
        }

2. Install Composer:

        curl -sS https://getcomposer.org/installer | php -d detect_unicode=Off

3. Use Composer to install your dependencies:

        php composer.phar install

4. Include Composer's autoloader in your PHP code

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

```PHP
use PredictionIO\PredictionIOClient;
$client = PredictionIOClient::factory(array("appkey" => "<your app key>"));
```

### Import a User Record from Your App

```PHP
// assume you have a user with user ID 5
$command = $client->getCommand('create_user', array('pio_uid' => 5));
$response = $client->execute($command);
```

### Import an Item Record from Your App

```PHP
// assume you have a book with ID 'bookId1' and we assign 1 as the type ID for book
$command = $client->getCommand('create_item', array('pio_iid' => 'bookId1', 'pio_itypes' => 1));
$response = $client->execute($command);
```

### Import a User Action (View) form Your App

```PHP
// assume this user has viewed this book item
$client->identify('5');
$client->execute($client->getCommand('record_action_on_item', array('pio_action' => 'view', 'pio_iid' => 'bookId1')));
```

### Retrieving Top N Recommendations for a User

```PHP
try {
    // assume you have created an itemrec engine named 'engine1'
    // we try to get top 10 recommendations for a user (user ID 5)
    $client->identify('5');
    $command = $client->getCommand('itemrec_get_top_n', array('pio_engine' => 'engine1', 'pio_n' => 10));
    $rec = $client->execute($command);
    print_r($rec);
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
```

### Retrieving Top N Similar Items for an Item

```PHP
try {
    // assume you have created an itemsim engine named 'engine2'
    // we try to get top 10 similar items for an item (item ID 6)
    $command = $client->getCommand('itemsim_get_top_n', array('pio_iid' => '6', 'pio_engine' => 'engine1', 'pio_n' => 10));
    $rec = $client->execute($command);
    print_r($rec);
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
```
