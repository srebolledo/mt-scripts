<?php
  require_once '../general/connection.php';
  mysql_select_db("twitter");
    while(1){
    $folder = "storedJsons";
    $newFolder = "storedJsons/processed";
    if ($handle = opendir($folder)) {
      while (false !== ($entry = readdir($handle))) {
          $ext = end(explode('.', $entry));
          if($ext == "txt"){
            $file = file_get_contents($folder."/".$entry);
            print_r(json_decode($file,true));
            storeInfo(json_decode($file,true));
            rename($folder."/".$entry, $newFolder."/".$entry);
          }
      }
      closedir($handle);
      sleep(20);
    }
}

function storeInfo($responseDecoded){

  foreach($responseDecoded as $jsonObject){

      $json_to_parse = json_encode($jsonObject);
      $userObject = $jsonObject;
      $followers = $userObject['followers_count'];
      $following = $userObject['friends_count'];
      $listCount = $userObject['listed_count'];
      $favouriteCount = $userObject['favourites_count'];
      $tweetCount = $userObject['statuses_count'];
      $screenName = $userObject['screen_name'];

      $sql = sprintf("update tweet_user_characteristics set number_of_tweets = $tweetCount, number_of_followers = '%s', number_of_following = '%s', number_of_lists = '%s', number_of_favourited = '%s', json_getted = '%s' where name = '%s'",
          $followers, $following, $listCount, $favouriteCount, mysql_real_escape_string($json_to_parse), $screenName );
      echo $sql."\n";
      echo "Updating: ".$screenName."\n";
      //mysql_query($sql) or die(mysql_error());
    }
}

?>