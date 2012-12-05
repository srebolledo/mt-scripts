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
  
  mysql_select_db("twitter");
  $counter=0;

  while(1){
    $sql = "select * from tweet_user_characteristics where issued = 0 limit 100";
    echo $sql."\n";
    $handler = mysql_query($sql) or die(mysql_error());
    $ids = array();
    $rows = array();
    $names = array();
    while($row = mysql_fetch_array($handler)){
        $ids[] = $row['id'];
        $rows[$row['id']]['id'] = $row['id'];
        $rows[$row['id']]['name'] = $row['name'];
        $names[] = $row['name'];
    }
    $sql = "update tweet_user_characteristics set issued = 1 where id in(".implode(",",$ids).");";
    echo $sql."\n";
    mysql_query($sql);

    echo "[".getTimeNow()."] peticion hecha.\n";
    $connection->request('GET',
    $connection->url('1.1/users/lookup'),
    array( 'screen_name'=> implode(",",$names) )
    );
    echo "[".getTimeNow()."] llegan datos.\n";
    $responseDecoded = json_decode($connection->response['response'],true);
    if(array_key_exists('errors', $responseDecoded)){
        echo "[".getTimeNow()."] Se encontro un error: ".$responseDecoded['error']."\n";
        $connection->request('GET',
          $connection->url('application/rate_limit_status')
        );
        $responseDecoded = json_decode($connection->response['response'],true);
        print_r($responseDecoded);

        continue;
    }
    // $responseDecoded = json_decode($connection->response['response'],true);
    $file = fopen($storeFolder."/".date('y-m-d_H:i:s')."-".$counter.".txt", "w+");
    fwrite($file, $connection->response['response'] );
    fclose($file);

    $counter++;
    if($counter == 180){
        $connection->request('GET',
          $connection->url('application/rate_limit_status')
        );
        $responseDecoded = json_decode($connection->response['response'],true);
        $remainingTime = time()-$responseDecoded['resources']['users']['/users/lookup']['reset'];
        if($remainingTime > 0 ) {
          echo "[".getTimeNow()."] Durmiendo por $remainingTime segundos\n";
          sleep($remainingTime);
        }

    }
  }
  function getTimeNow(){
    return date("Y-m-d H:i:s");
  }
?>
