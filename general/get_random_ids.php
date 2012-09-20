<?php
  include('connection.php');
  $i = 0;
  $numbers = array();
  $numbers_string = "";
  while($i<15000){
    $number = mt_rand(1,830000);
    if(!array_search($number, $numbers)){
      $numbers[] = $number;
      if($i == 0) $numbers_string = $number;
      else $numbers_string .= ",".$number;

      $i++;
    }
  
  }
  $i=0;
  $tweets = array();
  $sql = "Select * from dataTweetES where id IN (".$numbers_string.");";
  $handler = mysql_query($sql) or die(mysql_error());
  while($row = mysql_fetch_array($handler)){
    $tweets[] = array("id"=>($i+1),"user"=>$row['user'],"tweet"=>$row['tweet']);
    $i++;
  }
  $archivo = fopen("tweets.csv","w");
  foreach($tweets as $tweet) fputcsv($archivo, $tweet);

?>
