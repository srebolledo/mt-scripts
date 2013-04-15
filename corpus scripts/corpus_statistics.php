<?php
  $file = fopen("/Users/stephan/nltk_data/corpora/conll2002/test_twitter.test","r");
  $ner = array();
  $tweets_numbers = 0;
  while($line = fgets($file)){
    $parts = explode(" ",$line);
    if(count($parts) == 3){
      $ner_tag = trim($parts[2]);
      if($ner_tag[0] == "B"){
        if(!array_key_exists($ner_tag, $ner) ) $ner[$ner_tag] = 0;
        $ner[$ner_tag]++;
      }
    }
    else{
      $tweets_numbers++;
    }
  }
  print_r($ner);
  echo $tweets_numbers;
?>