<?php
  include '../general/connection.php';
  $sql = "Select * from tweets_new order by rand() limit 4000";
  mysql_select_db("twitter",$link);
  $handler = mysql_query($sql) or die(mysql_error());
  mkdir("tweets_in_txt");

  while ($row = mysql_fetch_array($handler)) {
    $tweet = $row["tweet"];
    $tweet = preg_replace('/[\s]+/',' ',$tweet);
    $file = fopen("tweets_in_txt/".$row["tweet_id"]."-unclassified.txt","w+");
    fprintf($file, "%s\n",$tweet);
    fclose($file);
  }
?>