<?php
  $url = "/wiki/Categor%C3%ADa:ES:Verbos_regulares";
  init($url);
  $counter = 1;

  function init($url){
    global $counter;
    $baseUrl = "http://es.wiktionary.org";
    $text = getInfo($baseUrl.$url);
    writeInfo($text,'<li><a href=',"verbos.txt");
    $urlNext = getUrlNext($text);

    if($urlNext != ""){
      echo "Pagina ".$counter."\n";
      $counter++;
      init(html_entity_decode($urlNext));
    }
  }

  function getInfo($urlToGather){
    $url = fopen($urlToGather,"r");
    $textToReturn = "";
    while($line = fgets($url)){

      $textToReturn .= $line;
    }
    return $textToReturn;
  }

  function getUrlNext($text){
    foreach(explode("\n",$text) as $lines){
      $line = strstr($lines,'(<a href="/w/index.php?title=Categor%C3%ADa:ES:Verbos_regulares&amp;pagefrom=');
      if($line){
        $parts = explode(" ",$line);
        $href = substr($parts[1],6);
        $href = str_replace('"', "", $href);
        return $href;
      }
    }
    return "";
  }

  function writeInfo($text, $patterTag,$filename){
    $file = fopen($filename,"a+");
    foreach(explode("\n",$text) as $lines){
      $line = strstr($lines, '<li><a href="/wiki');
      if($line){
        $parts = explode(">",$line);
        $parts = explode("title",$parts[1]);
        $adj = substr($parts[1],2);
        $adj = str_replace('"', "", $adj);
        if($adj != "Categoría:Español"){
          fwrite($file,$adj."\n");
        }
      }
    }

  }

?>