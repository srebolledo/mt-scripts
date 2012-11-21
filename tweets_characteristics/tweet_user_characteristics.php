<?php
  require_once '../general/connection.php';
  mysql_select_db("twitter");
  $sql = "select * from tweet_user_characteristics";
  $handler = mysql_query($sql) or die(mysql_error());
  $ids = array();
  while($row = mysql_fetch_array($handler)){
      $ids[] = $row['id'];
  }
  $sql = "update tweet_user_characteristics set issued = 1 where id in(".implode(",",$ids).");";
  mysql_query($sql);
  $sql = "select * from tweet_user_characteristics";
  $handler = mysql_query($sql) or die(mysql_error());
  while($row = mysql_fetch_array($handler)){
    $tweet_user_id = $row['id'];
    $json_url = "http://api.twitter.com/1/statuses/user_timeline.json?include_rts=true&screen_name=".$row['name']."&count=1";
    echo $json_url."\n";
    $jsonObject = json_decode(file_get_contents($json_url),true);
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
?>