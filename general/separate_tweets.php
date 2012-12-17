<?php
  $file = fopen('tweets_training.txt','r');
  $counter = 0;
  $folder = "tweets";
  mkdir($folder);
  while($line = fgets($file)){
    $counter++;
    $new_file = fopen($folder.'/tweet_'.$counter.".txt", "w");
    fwrite($new_file, trim($line));
    fclose($new_file);
  }
?>