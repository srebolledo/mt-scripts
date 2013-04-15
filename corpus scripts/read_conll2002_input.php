<?php
 /*File to parse the conll2002 train file and get a random sample of 100 elements to adjust the twitter corpus.*/
  $file = fopen("conll2002-train.txt","r");
  $counter = 0;
  $arrayConll = array();
  while($line = fgets($file) ){
    if($line != "\n") $arrayConll[$counter] .= $line;
    else $counter++;
  }
  $arrayConllUsed = array();
  $counter = 0;
  $max = 0;
  foreach($arrayConll as $key=>$value){
    $pizza = explode("\n",$value);
    $innerCounter = 0;
    foreach($pizza as $k=>$v){
      $innerCounter += strlen($v[0]);
    }
    if($innerCounter <= 140){
      $arrayConllUsed[$counter] = $value;
      $counter++;
    }

  }
  $rand_keys = array_rand($arrayConllUsed,150);
  $fileWriter = fopen("conll2002-twitter-train.txt","w+");
  foreach($rand_keys as $value){
    fwrite($fileWriter, $arrayConllUsed[$value]);
    fwrite($fileWriter, "\n");
  }
?>