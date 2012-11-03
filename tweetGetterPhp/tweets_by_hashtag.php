<?php
  include '../general/connection.php';
  $sql = "Select * from hashtags where tweet_count > 100 && tweet_count < 5000";
  mysql_select_db("twitter",$link);
  $handler = mysql_query($sql) or die(mysql_error());
  mkdir("tweets_by_hashtag");

  while ($row = mysql_fetch_array($handler)) {
    $hashtag_id = $row["id"];
    $file = fopen("tweets_by_hashtag/".$hashtag_id."-".$row["hashtag"].".txt","w+");
        $sql2 = "select tweet,hashtags_tweets.tweet_id from hashtags_tweets, tweets_new where hashtag_id = $hashtag_id and hashtags_tweets.tweet_id = tweets_new.id";
    echo $sql2."\n";
    $handler2 = mysql_query($sql2) or die(mysql_error());
    while($row2 = mysql_fetch_array($handler2)){
      $tweet = $row2["tweet"];
      $tweet = preg_replace('/[\s]+/',' ',$tweet);
      $tweet_id = $row2["tweet_id"];
      fprintf($file, "%s \t %s\n",$tweet_id, $tweet);
    }
    fclose($file);
  }
?>