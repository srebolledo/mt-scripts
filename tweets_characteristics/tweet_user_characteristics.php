<?php
  require_once '../general/connection.php';
  mysql_select_db("twitter");
  while(1){
    $sql = "select * from tweet_user_characteristics where issued = 0 limit 150";
    $handler = mysql_query($sql) or die(mysql_error());
    $ids = array();
    $rows = array();
    while($row = mysql_fetch_array($handler)){
        $ids[] = $row['id'];
        $rows[$row['id']]['id'] = $row['id'];
        $rows[$row['id']]['name'] = $row['name'];
    }
    $sql = "update tweet_user_characteristics set issued = 1 where id in(".implode(",",$ids).");";
    mysql_query($sql);
    foreach($rows as $row){
      $tweet_user_id = $row['id'];
      $json_url = "http://api.twitter.com/1/statuses/user_timeline.json?include_rts=true&screen_name=".$row['name']."&count=1";
      echo $json_url."\n";
	  $json_to_parse = file_get_contents($json_url);
	  if(!$json_to_parse) break;
      $jsonObject = json_decode($json_to_parse,true);
      print_r($jsonObject[0]['user']);
      $userObject = $jsonObject[0]['user'];
      $followers = $userObject['followers_count'];
      $following = $userObject['friends_count'];
      $listCount = $userObject['listed_count'];
      $favouriteCount = $userObject['favourites_count'];
      $tweetCount = $userObject['statuses_count'];
      $sql = "update tweet_user_characteristics set number_of_tweets = $tweetCount, number_of_followers = ".$followers.", number_of_following = ".$following.", number_of_lists = ".$listCount.", number_of_favourited = ".$favouriteCount." where id = ".$row['id'];
      echo $sql."\n";
      mysql_query($sql);
    }
	echo "\n\n***************************\n\nREACHED LIMIT!\n\n***************************\n\n";
    sleep(300);
    $sql = "update tweet_user_characteristics set issued = 0 where number_of_tweets = 0";
    mysql_query($sql);
  }
?>