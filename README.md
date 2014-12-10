PredictionIO PHP SDK
====================

[![Build Status](https://travis-ci.org/PredictionIO/PredictionIO-PHP-SDK.png?branch=develop)](https://travis-ci.org/PredictionIO/PredictionIO-PHP-SDK)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/PredictionIO/PredictionIO-PHP-SDK/badges/quality-score.png?s=bba570e3add382f4f56fcba65ec0b4f0b8622091)](https://scrutinizer-ci.com/g/PredictionIO/PredictionIO-PHP-SDK/)
[![Code Coverage](https://scrutinizer-ci.com/g/PredictionIO/PredictionIO-PHP-SDK/badges/coverage.png?s=db1de9fde081fedd79346b4aba562ab56853ed45)](https://scrutinizer-ci.com/g/PredictionIO/PredictionIO-PHP-SDK/)

Prerequisites
=============

* PHP 5.4+ (http://php.net/)
* PHP: cURL (http://php.net/manual/en/book.curl.php)
* Phing (http://www.phing.info/)
* ApiGen (http://apigen.org/)

Note: This SDK only supports Prediction IO version 0.8.2 or higher.

Support
=======


Forum
-----

https://groups.google.com/group/predictionio-user


Issue Tracker
-------------

https://predictionio.atlassian.net

If you are unsure whether a behavior is an issue, bringing it up in the forum is highly encouraged.


Getting Started
===============


By Composer
-----------

The easiest way to install PredictionIO PHP client is to use [Composer](http://getcomposer.org/).

1. Add `predictionio/predictionio` as a dependency in your project's ``composer.json`` file:

        {
            "require": {
                "predictionio/predictionio": "~0.8.2"
            }
        }

2. Install Composer:

        curl -sS https://getcomposer.org/installer | php -d detect_unicode=Off

3. Use Composer to install your dependencies:

        php composer.phar install

4. Include Composer's autoloader in your PHP code

        require_once("vendor/autoload.php");


Supported Commands
==================

For a list of supported commands, please refer to the
[API documentation](http://docs.prediction.io/php/api/).


Usage
=====

This package is a web service client based on Guzzle.
A few quick examples are shown below.

Instantiate PredictionIO API Event Client
-----------------------------------

```PHP
use predictionio\EventClient;
$accessKey = 'j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O';
$client = new EventClient($accessKey, 'http://localhost:7070');
```

Set a User Record from Your App
-------------------------------

```PHP
// assume you have a user with user ID 5
$response = $client->setUser(5);
```


Set an Item Record from Your App
---------------------------------

```PHP
// assume you have a book with ID 'bookId1' and we assign 1 as the type ID for book
$response = $client->setItem('bookId1', array('itypes' => 1));
```


Import a User Action (View) form Your App
-----------------------------------------

```PHP
// assume this user has viewed this book item
$client->recordUserActionOnItem('view', 5, 'bookId1');
```


Retrieving Prediction Result
----------------------------

```PHP
// assume you have created an itemrank engine on localhost:8000
// we try to get ranking of 5 items (item IDs: 1, 2, 3, 4, 5) for a user (user ID 7)

$engineClient = new EngineClient('http://localhost:8000');
$response = $engineClient->sendQuery(array('uid'=>7, 'iids'=>array(1,2,3,4,5)));

print_r($rec);
```
