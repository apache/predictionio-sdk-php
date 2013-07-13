<?php

require_once("../build/artifacts/predictionio.phar");

use PredictionIO\PredictionIOClient;

if (!isset($argv[1]) || !isset($argv[2])) {
	print "Usage: $argv[0] <appkey> <data file>\n";
	exit(1);
}

$appkey = $argv[1];
$input = $argv[2];

// Instantiate a client
$client = PredictionIOClient::factory(array("appkey" => $appkey));

if (!file_exists($input)) {
	print "$input not found!\n";
	exit(1);
}

if (!is_readable($input)) {
	print "$input cannot be read!\n";
	exit(1);
}

// Scan sample data file and import ratings
$handle = fopen($input, "r");
while (!feof($handle)) {
	$line = fgets($handle);
	$tuple = explode("\t", $line);
	if (count($tuple) == 3) {
		try {
			$client->identify($tuple[0]);
			$client->execute($client->getCommand("record_action_on_item", array("pio_action" => "rate", "pio_iid" => $tuple[1], "pio_rate" => intval($tuple[2]))));
		} catch (Guzzle\Http\Exception\ClientErrorResponseException $e) {
			print $e->getResponse()->getBody()."\n\n";
		}
	}
}
fclose($handle);

?>
