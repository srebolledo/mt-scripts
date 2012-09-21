<?php
  require_once '../general/connection.php';
  $sql = "select id, tweet from tweets";
  $handler = mysql_query($sql) or die(mysql_error());
  while($row = mysql_fetch_array($handler)){
    $tweet = trim($row['tweet']);
    $count_words = count(explode(' ',$tweet));
    $count_tweet_mentions = preg_match_all('/@.*/', $tweet, $matches);
    $count_tweet_hash = preg_match_all('/#.*/', $tweet, $matches);
    $count_url = preg_match_all('/http:\/\/.*/', $tweet, $matches);
    $id = $row['id'];
    //echo $tweet." (".$count_word."), (".$count_tweet_mentions."), ($count_url), ($count_tweet_hash)\n";
    $sql = "Insert into tweet_characteristics (count_words, count_tweet_mentions, count_tweet_hash) values ($count_words, $count_tweet_mentions, $count_tweet_hash)";
    echo $sql."\n";

  }
?>