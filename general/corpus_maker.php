<?php
  $file = fopen("tweets_training.csv", 'r');
  $new_file = fopen("tweets_training.txt", 'a+');
  while(($data = fgetcsv($file,"1000",",")) !== FALSE){
    $tweet = $data[0];
    $replacer = array();
    //replacing url because it doesnt have info
    $pattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
    $tweet = preg_replace($pattern, "*URL*", $tweet);
    //replacing hashes
    $replacer[] = "#";
    $replacer[] = "RT";
    $replacer[] = "/";
    $tweet = trim(str_replace($replacer, "", $tweet));

    fwrite($new_file, $tweet."\n");
  }

?>