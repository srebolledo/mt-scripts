<?php
	require('../general/connection.php');
	date_default_timezone_set('America/Santiago');
	$files = scandir(".");
	#print_r($files);
	$i=0;
	foreach ($files as $file){
		if(pathinfo($file, PATHINFO_EXTENSION) == "json"){
			#echo $file."\n";
			$json = (string)@file_get_contents($file);
			$arch = json_decode($json,true);
			// print_r($arch);

			foreach($arch["results"] as $tweet){

				$sql = "insert into new_tweets values (NULL,'".mysql_escape_string($tweet['id_str'])."','".mysql_escape_string($tweet["from_user"])."','200','".$tweet["created_at"]."','0','none','lat','long','Here','check','".mysql_escape_string($tweet['text'])."','ES','Chile');";
				echo $sql."\n";
				mysql_query($sql);
				$i++;
			}
		}

	}
	echo "Tweets totales: ".$i."\n";
?>