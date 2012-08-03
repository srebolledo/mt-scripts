<?php
	include('connection.php');
	define('CORPUS_TWEETS_ALL','tweets-all-corpus-with-nulls.csv');
	$cd = getcwd();
	//chdir("../../data-tweets/");
	$file_id = fopen("faltantes.csv", 'r');
	$i =1;
	$tweetCount = 0;
	for($c = 0;$c <3000000;$c++) $a = fgets($file_id);
	while(!feof($file_id)){
			$line = fgetcsv($file_id,0,'	');
			//echo $i."\n";
			print_r($line);
			if($line[10] != 'null'){
				$query = "";
				$j=0;
				foreach($line as $tweet){
					if($j == 0) $query = "'".addslashes($tweet)."'";
					else $query .= ",'".addslashes($tweet)."'";
					$j++;
				}
				//echo $query."\n";
				//$sql = "insert into dataTweets (id,tweet_id,user,status,date,checksum,tweet_reference,field6,field7,field8,field9,tweet) values (\'\',".$query.");";
				$sql = "INSERT INTO `ner-twitter`.`dataTweets` (`id`, `user`, `status`, `date`, `checksum`, `tweet_reference`, `field6`, `field7`, `field8`, `field9`, `tweet`) VALUES ($query);";
				//echo $sql;
				
				$tweetCount++;
				echo "                                        \r";
				echo "Tweets importados: ".$tweetCount."\r";
				mysql_query($sql,$link) or die(mysql_error());
			}
		

		$i++;
	}
	fclose($file_id);
?>