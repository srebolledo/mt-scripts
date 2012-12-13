<?php
  require_once '../general/connection.php';
  require_once 'lib_twitter/tmhOAuth.php';
  require_once 'lib_twitter/secret.php';
  $storeFolder = "storedJsons";
   $connection = new tmhOAuth(array(
    'consumer_key' => $consumer_key,
    'consumer_secret' => $consumer_secret,
    'user_token' => $access_token,
    'user_secret' => $access_token_secret,
  ));
  
 
  $connection->request('GET',
    $connection->url('1.1/application/rate_limit_status')
  );
  $responseDecoded = json_decode($connection->response['response'],true);
  $time = time();
  echo $time-$responseDecoded['resources']['users']['/users/lookup']['reset'];
  // print_r($responseDecoded);
?>