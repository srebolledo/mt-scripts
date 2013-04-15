<?php
  /*Este archivo cambia las mayusculas a minusculas, quita las repeticiones > 3 de las letras.*/
  $file = fopen("/Users/stephan/nltk_data/corpora/conll2002/esp.train7","r");
  $filewritter = fopen("esp.train.twitter","w");
  $vowels = array('a','e','i','o','u');
  while($line = fgets($file)){
    $parts = explode(" ",$line);
    if(count($parts) == 3){
       /*minusculas*/
      $parts[0] = strtolower($parts[0]);
      fwrite($filewritter,implode(" ",$parts));
    }
    else fwrite($filewritter, "\n");

  }

?>