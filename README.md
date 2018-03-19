# Apache PredictionIO PHP SDK


[![Build Status](https://travis-ci.org/apache/incubator-predictionio-sdk-php.svg?branch=develop)](https://travis-ci.org/apache/incubator-predictionio-sdk-php)

## Prerequisites

* PHP 5.4+ (http://php.net/)
* PHP: cURL (http://php.net/manual/en/book.curl.php)
* Phing (http://www.phing.info/)
* ApiGen (http://apigen.org/)

Note: This SDK only supports Apache PredictionIO version 0.8.2 or higher.

## Getting Started

The easiest way to install PredictionIO PHP client is to use [Composer](http://getcomposer.org/).

1. `predictionio` is available on [Packagist](https://packagist.org) and can be installed using [Composer](https://getcomposer.org/):

        composer require predictionio/predictionio

2. Include Composer's autoloader in your PHP code

        require_once("vendor/autoload.php");

## Usage

This package is a web service client based on Guzzle.
A few quick examples are shown below.

### Instantiate PredictionIO API Event Client

```PHP
use predictionio\EventClient;
$accessKey = 'j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O';
$client = new EventClient($accessKey, 'http://localhost:7070');
```

### Set a User Record from Your App

```PHP
// assume you have a user with user ID 5
$response = $client->setUser(5);
```


### Set an Item Record from Your App

```PHP
// assume you have a book with ID 'bookId1' and we assign 1 as the type ID for book
$response = $client->setItem('bookId1', array('itypes' => 1));
```


### Import a User Action (View) form Your App

```PHP
// assume this user has viewed this book item
$client->recordUserActionOnItem('view', 5, 'bookId1');
```


### Retrieving Prediction Result

```PHP
// assume you have created an itemrank engine on localhost:8000
// we try to get ranking of 5 items (item IDs: 1, 2, 3, 4, 5) for a user (user ID 7)

$engineClient = new EngineClient('http://localhost:8000');
$response = $engineClient->sendQuery(array('uid'=>7, 'iids'=>array(1,2,3,4,5)));

print_r($response);
```

## Bugs and Feature Requests

Use [Apache JIRA](https://issues.apache.org/jira/browse/PIO) to report bugs or request new features.

## Community

Keep track of development and community news.

*   Subscribe to the user mailing list <mailto:user-subscribe@predictionio.apache.org>
    and the dev mailing list <mailto:dev-subscribe@predictionio.apache.org>
*   Follow [@PredictionIO](https://twitter.com/PredictionIO) on Twitter.

## Contributing

Read the [Contribute Code](http://predictionio.apache.org/community/contribute-code/) page.

## License

Apache PredictionIO is under [Apache 2
license](http://www.apache.org/licenses/LICENSE-2.0.html).
