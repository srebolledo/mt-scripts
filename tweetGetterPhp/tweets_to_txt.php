<?php
  include '../general/conection.php';
  $sql = "Select * from new_tweets";
  $handler = mysql_query($sql);
  mkdir("tweets_in_txt");
  while ($row = mysql_fetch_array($handler)) {
    $tweet = $row["tweet"];
    $file = fopen($row["tweet_id"],"w+");
    fprintf($file, "%s\n",$tweet);
    fclose($file);
  }
?>