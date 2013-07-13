<?php

require_once("../build/artifacts/predictionio.phar");

use PredictionIO\PredictionIOClient;

if (!isset($argv[1])) {
	print "Usage: $argv[0] <appkey>\n";
	exit(1);
}

$appkey = $argv[1];

// Instantiate a client
$client = PredictionIOClient::factory(array("appkey" => $appkey));

try {
	// Create, get and delete a user
	print "Create, get and delete a user:\n";

	$uid = "foobar";

	$command = $client->getCommand('create_user', array('pio_uid' => $uid));
	$command->setInactive("true");
	$command->set("gender", "F");
	$response =$client->execute($command);
	print_r($response);

	$command = $client->getCommand('get_user', array('pio_uid' => $uid));
	$response = $client->execute($command);
	print_r($response);

	$command = $client->getCommand('delete_user', array('pio_uid' => $uid));
	$response =$client->execute($command);
	print_r($response);

	print "\n";

	// Create, get and delete an item
	print "Create, get and delete an item:\n";

	$iid = "barbaz";

	$command = $client->getCommand('create_item', array('pio_iid' => $iid));
	$command->setItypes(array("dead", "beef"));
	$command->setPrice(9.99);
	$command->set("weight", "10");
	$response = $client->execute($command);
	print_r($response);

	$command = $client->getCommand('get_item', array('pio_iid' => $iid));
	$response = $client->execute($command);
	print_r($response);

	$command = $client->getCommand('delete_item', array('pio_iid' => $iid));
	$response = $client->execute($command);
	print_r($response);

	print "\n";

	// Retrieving Top N Recommendations for a User
	print "Get top 10 recommendations for a user:\n";

	$client->identify("1");
	$response = $client->execute($client->getCommand("itemrec_get_top_n", array("pio_engine" => "movies", "pio_n" => 10)));
	print_r($response);
} catch (Guzzle\Http\Exception\ClientErrorResponseException $e) {
	print $e->getResponse()->getBody()."\n\n";
}

?>
