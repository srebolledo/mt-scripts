<?php
  $adjetivosFile = fopen("adjetivos.txt","r");
  $adverbiosFile = fopen("adverbios.txt","r");
  $verbosFile = fopen("verbos.txt","r");
  $paisesFile = fopen("lugares.txt","r");
  $adverbios = array();
  $adjetivos = array();
  $verbos = array();
  $paises = array();
  $search = array("á",'é','í','ó','ú','ñ');
  $replace = array('a','e','i','o','u','n');
  while($line = fgets($adjetivosFile)){
    $adjetivos[] = str_replace($search, $replace, strtolower($line));
  }
  while($line = fgets($adverbiosFile)){
    
    $adverbios[] = str_replace($search, $replace, strtolower($line));
  }
  while($line = fgets($verbosFile)){
    $verbos[] = str_replace($search, $replace, strtolower($line));
  }
  while($line = fgets($paisesFile)){
    $verbos[] = str_replace($search, $replace, strtolower($line));
  }
  $file3 = fopen("train_tweets.txt","r");
  $fileWritter = fopen("train_tweets_fixed.txt","a+");
  $pronombres = array("yo","tu","vos","usted","el","ella","ello","nosotros","nosotras","ustedes","vosotros","vosotras","ellos","ellas","mi","ti","consigo","me","te","se","lo","la","le","se","nos","os","los","las","les");
  $posesivos = array("mio","tuyo","suyo","nuestro","vuestro","suyo","mia","tuya","suya","nuestra","vuestra","suya","mios","tuyos","suyos","nuestros","vuestros","suyos","mias","tuyas","suyas","nuestras","vuestras","suyas");
  $demostrativos = array("este","ese","aquel","esta","esa","aquella","esto","eso","aquello","estos","esos","aquellos","estas","esas","aquellas");
  $indefindos = array("uno","una","uno","unos","unas","alguno","alguna","algo","algunos","algunas","ninguno","ninguna","nada","ningunos","ningunas","poco","poca","pocos","pocas","escaso","escasa","escaso","escasos","escasas","mucho","mucha","mucho","muchos","muchas","demasiado","demasiada","demasiado","demasiados","demasiadas","todo","toda","todo","todos","todas","varios","varias","otro","otra","otro","otros","otras","mismo","misma","mismo","mismos","mismas","tan,","tanto","tanta","tanto","tantos","tantas","alguien","nadie","cualquiera","cualesquiera","quienquiera","quienesquiera","demas","demas");
  $interrogativos = array("que","quien","quienes","cual","cuales","cuanto","cuantos");
  $preposiciones = array("a","ante","bajo","cabe","con","contra","de","desde","en","entre","hacia","hasta","para","por","segun","sin","sobre","tras");
  $tweets = array();
  $tweetsCounter = 0;
  $replaces = array("!","º","ª",'\\',"!","|","\"","'","·","#","$","%","&","¬","/","(",")","?","¡","¿","`","¨","ç","{","}","[","]","<",">",",",".",";",":","-","_","=");
  while($line = fgets($file3)){
    $parts = explode(" ",$line);
    if(count($parts) == 3){
      $tweets[$tweetsCounter][] = $parts;
    }
    else $tweetsCounter++;
  }
  foreach($tweets as &$tweetParts){
    foreach($tweetParts as &$tweet){
      $tweet[0] = trim(str_replace($replaces, "", $tweet[0]));
      if(in_array($tweet[0], $adjetivos)) $tweet[1] = "AN";
      if(in_array($tweet[0],$adverbios)) $tweet[1] = "RG";
      if(in_array($tweet[0],$pronombres)) $tweet[1] = "PP";
      if(in_array($tweet[0],$posesivos)) $tweet[1] = "PO";
      if(in_array($tweet[0],$demostrativos)) $tweet[1] = "PD";
      if(in_array($tweet[0],$indefindos)) $tweet[1] = "PI";
      if(in_array($tweet[0],$preposiciones)) $tweet[1] = "SP";
      if(in_array($tweet[0],$verbos)) $tweet[1] = "VA";
      if(in_array($tweet[0],$paises)){
        $tweet[1] = "NC";
        $tweet[2] = "B-LOC";
      }
      fwrite($fileWritter,$tweet[0]." ".$tweet[1]." ".$tweet[2]);
    }
    fwrite($fileWritter,"\n");
  }
  print_r($tweets);

?>