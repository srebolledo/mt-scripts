<?php
  require_once '../general/connection.php';
  require_once 'lib_twitter/tmhOAuth.php';
  require_once 'lib_twitter/secret.php';

   $connection = new tmhOAuth(array(
    'consumer_key' => $consumer_key,
    'consumer_secret' => $consumer_secret,
    'user_token' => $access_token,
    'user_secret' => $access_token_secret,
  ));
  
  mysql_select_db("twitter");
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

    $responseDecoded = json_decode($connection->response['response'],true);
    print_r($responseDecoded);
    foreach($responseDecoded as $jsonObject){

/*      $tweet_user_id = $row['id'];
      $json_url = "http://api.twitter.com/1/users/show.json?screen_name=".$row['name'];
      echo $json_url."\n";
	  $json_to_parse = file_get_contents($json_url);
  
	  if(!$json_to_parse) {
      break;
    }
      $jsonObject = json_decode($json_to_parse,true);
  */    
      $json_to_parse = json_encode($jsonObject);
      $userObject = $jsonObject;
      $followers = $userObject['followers_count'];
      $following = $userObject['friends_count'];
      $listCount = $userObject['listed_count'];
      $favouriteCount = $userObject['favourites_count'];
      $tweetCount = $userObject['statuses_count'];
      $screenName = $userObject['screen_name'];
      
      $sql = sprintf("update tweet_user_characteristics set number_of_tweets = $tweetCount, number_of_followers = '%s', number_of_following = '%s', number_of_lists = '%s', number_of_favourited = '%s', json_getted = '%s' where name = '%s'",$followers, $following, $listCount, $favouriteCount, mysql_real_escape_string($json_to_parse), $screenName );
      //echo $sql."\n";
      echo "Updating: ".$screenName."\n";
      mysql_query($sql) or die(mysql_error());  
    }
	 echo "\n\n***************************\n\nREACHED LIMIT!\n\n***************************\n\n";
    sleep(1);
    /*$sql = "update tweet_user_characteristics set issued = 0 where number_of_tweets = 0";
    mysql_query($sql);*/
  }
?>