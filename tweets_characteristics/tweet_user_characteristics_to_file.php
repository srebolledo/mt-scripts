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
    mysql_query($sql);

    
    $connection->request('GET',
    $connection->url('1.1/users/lookup'),
    array( 'screen_name'=> implode(",",$names) )
    );

    // $responseDecoded = json_decode($connection->response['response'],true);
    $file = fopen($storeFolder."/".date('y-m-d_H:i:s')."-".$counter.".txt", "w+");
    fwrite($file, $connection->response['response'] );
    fclose($file);
    $counter++;
  }
?>