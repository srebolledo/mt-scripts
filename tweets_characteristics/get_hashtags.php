<?php
  require_once '../general/connection.php';
  require_once '../general/get_tweets.php';
  mysql_select_db('twitter');
  $sql = "select * from tweets";
  $handler = mysql_query($sql) or die(mysql_error());
  while($row = mysql_fetch_array($handler)){
    $tweet = $row["tweet"];
    
    $count_tweet_hash = preg_match('/#.*/', $tweet, $matches);
    if(count($matches) > 0){
      foreach($matches as $match){
        $match = str_replace("#","%23",$match);
        fetchTweets($match,true);
      }
    }
    
  }
?>