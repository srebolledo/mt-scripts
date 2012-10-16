<?php
require('../general/connection.php');
mysql_select_db('ner-twitter');

date_default_timezone_set('America/Santiago');

$arrayOfConcepts = array('accidente','fiesta','desfile','despedida','torneo','partido','reunion','concierto','festival','desfile','campeonato',
  'mundial','feria','cumbre','congreso','choque','robo','felicitacion','premio','premiacion','ceremonia','taco','trafico','evento');

foreach($arrayOfConcepts as $concept){
  $q = $concept;
  $first_page = true;
  fetchTweets($q,$first_page);
}

function fetchTweets($q, $first_page){
  while($response = getTweets($q,$first_page)){
    $jsonobj = json_decode($response,false);
    //print_r($jsonobj);
    $first_page = false;
    if($jsonobj != null){
      $q = $jsonobj->next_page;
      echo "\n";
      print_r($jsonobj->next_page);
      foreach($jsonobj->results as $item){
        
        $tweet_id = $item->id_str;
        $user = $item->from_user;
        $user_id = $item->from_user_id_str;
        $created_at = date('Y-m-d H:i:s',strtotime($item->created_at));
        $tweet_reference = $item->in_reply_to_status_id_str;
        $from_user = $item->from_user;
        $from_user_id = $item->from_user_id;
        $text = $item->text;
        $source = $item->source;
        $geo = $item->geo;
        $iso_language_code = $item->iso_language_code;
        $to_user_id = $item->to_user_id;
        if($geo != null) {
          print_r($geo);
          $lat = $geo->coordinates[0];
          $long = $geo->coordinates[1];
        }
        else{
          $lat = 0;
          $long = 0;
        }

        if($to_user_id==""){ $to_user_id = 0; }
        //$query = mysql_real_escape_string($query);
        //mysql_select_db("database", $con);
        // // SQL query to create table available at http://snipplr.com/view/56995/sql-query-to-create-a-table-in-mysql-to-store-tweets/
        //$query = "INSERT into tweets VALUES ($id,'$created_at','$from_user',$from_user_id,'$text','$source','$geo','$iso_language_code','$profile_image_url',$to_user_id,'$q')";
        $query = "Insert into tweets values (NULL, '$tweet_id', '$user', '$user_id', '$created_at', '','$tweet_reference', '$lat','$long','','','$text', '$iso_language_code', '');";
        echo $query;
        $result = mysql_query($query);

      }
      
      // mysql_close($con);
    }
    else {
      echo "\n Saliendo!";
      break;

    }



  }


}

function getTweets($q = null, $first_page = false){
  if(!$q) return null;
  if($first_page) $request = "http://search.twitter.com/search.json?locale=es&q=".urlencode($q);
  else {
    $request = "http://search.twitter.com/search.json".$q;
  }
  return file_get_contents($request);


}
?>