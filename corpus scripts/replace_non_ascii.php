
<?php
$file = fopen("esp.train7","r");
  $counter = 0;
  $arrayConll = array();
  while($line = fgets($file) ){
    if($line != "\n") $arrayConll[$counter] .= $line;
    else $counter++;
  }
  $arrayConllUsed = array();
  $counter = 1;
  $max = 0;
  $file2 = fopen("esp.train7-ascii","w+");
  $stringToFile = "";
  foreach($arrayConll as $key=>$value){
    $pizza = explode("\n",$value);
    $innerCounter = 0;
    $nercounter = 0;
    foreach($pizza as $k=>$v){
      $p = explode(" ",$v);
      fwrite($file2,preg_replace('/[^\x20-\x7f]/', '',$p[0])." ".$p[1]." ".$p[2]."\n");3
    }
    fwrite($file2, "\n");
    $counter++;
  }
?>