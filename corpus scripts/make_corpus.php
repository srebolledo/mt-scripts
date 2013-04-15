<?php
  //include("corpus_array.php");
  $tweet_parts = array();
  include("../general/connection.php");
  $sql = "select * from tweets_users";
  $handler = mysql_query($sql);
  $tweets_users = array();
  $tags = array();
  $tags['1'] = "PP";
  $tags['2'] = "NC";
  $tags['3'] = "PP";
  $tags['4'] = "VA";
  $tags['5'] = "AN";
  $tags['6'] = "RG";
  $tags['7'] = "SP";
  $tags['8'] = "CC";
  $tags['9'] = "I";
  $tags['10'] = "XRT";
  $tags['11'] = "XX";
  $tags['12'] = "NP";
  $tags['13'] = "XURL";
  $tags['14'] = "XX";
  $tags['15'] = "XX";
  $tags['16'] = "PD";
  $tags['17'] = "PO";
  $tags['18'] = "AC";
  $tags['19'] = "PT";
  $tags['20'] =  "XX";
  while($row = mysql_fetch_array($handler)){
    $tweets_users[] = $row;
  }
  $twitsTaggedBefore = array();
  foreach($tweets_users as $key=>$value){
    $tweet_id = $value["tweet_id"];
    $position_tweet = $value["position_tweet"];
    $word = $value["word"];
    $ner_tag_id = $value["ner_tag_id"];
    $tag_id = $value["tag_id"];
    if(!is_array($tweet_part[$tweet_id])){
      $tweet_part[$tweet_id] = array();
    }
    $tweet_part[$tweet_id][$position_tweet] = array("word"=>$word, "ner_tag_id" => $ner_tag_id, "tag_id"=>$tag_id, 'tweet_id'=>$tweet_id, "position_tweet"=>$value['position_tweet']);
    $twitsTaggedBefore[$value['tweet_id']]= returnTaggedTweets($value['tweet_id']);

  }
  print_r($twitsTaggedBefore);
  
  $NER = array(11=>"PER",12=>"LOC",13=>"ORG",16=>"MISC");
  $allExamples = "";
  foreach($tweet_part as $key=>$value){
    $file = fopen("totag/tweet_".$key.".txt", "w");
    $totag = "";
    $returnString = "";
    $BIO = 0;
    foreach($value as $tagged_tweet){
      if($tagged_tweet['word'] != ""){
        if($tagged_tweet['ner_tag_id'] != 15){
          if($BIO == $tagged_tweet['ner_tag_id']) $BIO = "I";
          else $BIO = "B";

          // $tag = $twitsTaggedBefore[$tagged_tweet['tweet_id']][$tagged_tweet['position_tweet'].$tagged_tweet['word']];
          // $tag = $tag != "" ? $tag : "-NONE-";
          $returnString .= $tagged_tweet['word']." ".$tags[$tagged_tweet['tag']]." ".$BIO."-".$NER[$tagged_tweet['ner_tag_id']]."\n";
        }
        else{
          $returnString .= $tagged_tweet['word']." ".$tag." O\n";
        }
        $totag .= $tagged_tweet['word']." ";
        $BIO = $tagged_tweet['ner_tag_id'];
      }
    }

    // $file = fopen("little_corpus/tweet_".$key.".txt","w");
    // fwrite($file,$returnString);
    $allExamples.=$returnString."\n";
  }
  // $file = fopen(" -train.txt","r");
  // $counter = 0;
  // $arrayConll = array();
  // while($line = fgets($file) ){
  //   if($line != "\n") $arrayConll[$counter] .= $line;
  //   else $counter++;
  // }
  // $arrayConllUsed = array();
  // $counter = 0;
  // $max = 0;
  // foreach($arrayConll as $key=>$value){
  //   $pizza = explode("\n",$value);
  //   $innerCounter = 0;
  //   foreach($pizza as $k=>$v){
  //     $innerCounter += strlen($v[0]);
  //   }
  //   if($innerCounter <= 140){
  //     $arrayConllUsed[$counter] = $value;
  //     $counter++;
  //   }

  // }
  // $rand_keys = array_rand($arrayConllUsed,1000);
  $fileWriter = fopen("train_tweets.txt","w+");
  // foreach($rand_keys as $value){
  //   $allExamples .= $arrayConllUsed[$value]."\n";
  // }
  fwrite($fileWriter, $allExamples);


  function returnTaggedTweets($tweet_id){
    $stringFile = file_get_contents("totag/taggedtweet_".$tweet_id.".txt");
    $taggedParts = explode("\n", $stringFile);
    $tags = array();
    $flagAt = false;
    $counter = 1;
    for($i=0;$i<count($taggedParts); $i++){
      $p2 = explode(" ",$taggedParts[$i]);
      if(count($p2) == 2){
        if($p2[0] == "@"){
          $flagAt = true;
          $counter--;
        }
        else{
          if($flagAt) {
            $tags[$counter."@".$p2[0]] = "NC";
            $flagAt = false;
          }
          else $tags[$counter."".$p2[0]] = is_numeric($p2[0])? "Z" : str_replace(")", "", $p2[1]);
        }
      }
      $counter++;
    }
    return $tags;

  }
?>