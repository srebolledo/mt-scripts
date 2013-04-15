<?php
  $file = fopen("tweet_conll2002_tagged.txt","r");
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
    $nercounter = 0;
    foreach($pizza as $k=>$v){
      $innerCounter += strlen($v[0]);
      if($v[3] != "O") $nercounter++;
    }
    if($innerCounter <= 140 && $nercounter > 1){
      $arrayConllUsed[$counter] = $value;
      $counter++;
    }

  }
  $rand_keys = array_rand($arrayConllUsed,4000);
  print_r($rand_keys);
  echo count($arrayConllUsed)."\n";
  $fileWriter = fopen("esp.train7","w+");
  foreach($rand_keys as $value){
    $allExamples .= $arrayConllUsed[$value]."\n";
  }
  fwrite($fileWriter, $allExamples);

?>