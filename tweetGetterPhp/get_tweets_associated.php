<?php
  include '../general/connection.php';
  $sql = "Select * from tweets_associated where number_of_tweets > 30 and number_of_tweets < 5000 order by rand()";
  mysql_select_db("twitter",$link);
  $handler = mysql_query($sql) or die(mysql_error());
  $counter = 0;
  $set = 0;
  $folder = "tweets_associated";
  mkdir($folder);
  while ($row = mysql_fetch_array($handler, MYSQL_NUM)) {
     // print_r($row);
    $set = $counter % 100 == 0 ? $set+1 : $set;
    echo $counter." ".$set."\n";
    $file = "tweets_associated_set_".$set.".txt";
    $hashtag_id = $row["id"];
    $file = fopen($folder."/".$file,"a");
    foreach ($row as $key => &$value) {
      $value = trim($value);
    }
    $line = implode(", ", $row);
    fprintf($file, "%s \n",$line);
    $counter++;
    fclose($file);
  }
?>