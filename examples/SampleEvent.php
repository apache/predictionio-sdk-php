<?php
require_once("vendor/autoload.php");

use predictionio\EventClient;
use predictionio\PredictionIOAPIError;

try {
  // check Event Server status
  $client = new EventClient(
    "j4jIdbq59JsF2f4CXwwkIiVHNFnyNvWXqMqXxcIbQDqFRz5K0fe9e3QfqjKwvW3O");
  $response=$client->getStatus();
  echo($response);

  // set user with event time
  $response=$client->setUser(9, array('age'=>10), 
                        '2014-01-01T10:20:30.400+08:00');
  print_r($response);

  // set user 
  $response=$client->setUser(8, array('age'=>20, 'gender'=>'M'));
  print_r($response);

  // unset user
  $response=$client->unsetUser(8, array('age'=>20));
  print_r($response);

  // delete user
  $response=$client->deleteUser(9);
  print_r($response);
  
  // set item with event time
  $response=$client->setItem(3, array('itypes'=>array('1')), 
                        '2013-12-20T05:15:25.350+08:00');
  print_r($response);

  // set item 
  $response=$client->setItem(2, array('itypes'=>array('1')));
  print_r($response);

  // unset item 
  $response=$client->unsetItem(2, array('itypes'=>array('1')));
  print_r($response);

  // delete item 
  $response=$client->deleteItem(3, '2000-01-01T01:01:01.001+01:00');
  print_r($response);

  // record user action on item
  $response=$client->recordUserActionOnItem('view', 8, 2);
  print_r($response);

  // create event
  $response=$client->createEvent(array(
                        'event' => 'my_event',
                        'entityType' => 'user',
                        'entityId' => '8',
                        'properties' => array('prop1'=>1, 'prop2'=>2),
                   ));
  print_r($response); 

  // get event
  $response=$client->getEvent('U_7eotSbeeK0BwshqEfRFAAAAUm-8gOyjP3FR73aBFo');
  print_r($response);                       

} catch (PredictionIOAPIError $e) {
  echo $e->getMessage();
}
?>
