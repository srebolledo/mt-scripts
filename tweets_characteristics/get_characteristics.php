<?php
  require_once '../general/connection.php';
  mysql_select_db("twitter");
  mysql_query("truncate table tweet_characteristics");
  $sql = "select id, tweet, tweet_reference from tweets_new limit 1";
  $handler = mysql_query($sql) or die(mysql_error());
  while($row = mysql_fetch_array($handler)){
    $tweet = trim($row['tweet']);
    $tweet = preg_replace('/[\s]+/',' ',$tweet);
    $count_words = count(explode(' ',$tweet));
    $count_tweet_mentions = preg_match_all('/@.*/', $tweet, $matches);
    $count_tweet_hash = preg_match_all('/#.*/', $tweet, $matches);
    $count_url = preg_match_all('/http:\/\/.*/', $tweet, $matches);
    $part_of_conversation = $row["tweet_reference"]!= 0 ? "1":"0" ;
    $id = $row['id'];
    $sql = "Insert into tweet_characteristics values (null, $id, $count_words,0,0,0, $count_tweet_mentions, $count_tweet_hash, $part_of_conversation)";
    echo $sql."\n";

  }
?>