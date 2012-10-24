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
        if(!hashTagExists($match)) hashAdd($match);
      }
    }
  }

  function hashTagExists($hashTag=false){
    if($hashTag){
      $sql = "select hashtag from hastags where hashtag='$hashTag'";
      if(mysql_num_rows(mysql_query($sql)) > 0) return true;
      else return false;
    }
    return false;
  }

  function hashAdd($hashTag=false){
    if($hashTag){
      $sql = "insert into hashtag ('hashTag') values ('$hashTag')";
      mysql_query($sql);
    }
  }

?>