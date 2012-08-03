<?php
	$cd = getcwd();
	//echo $cd;
	/*Changing to data-tweets directory*/
	chdir("../../data-tweets");
	$languageFile = fopen('twDCC_lang.txt','r');
	define('corpus_tweets', 'tweets-all-corpus-with-nulls.csv');
	while(!feof($languageFile)){
		$line = fgets($languageFile);
		$language = explode('|', $line);
		$tweet_id = $language[0];
		$language = trim($language[1]);
		//$tweet = shell_exec('grep '.$tweet_id. " ".corpus_tweets);
		//echo $tweet."\n";
		chdir($cd."/processed/");
		if(file_exists($language."-only-id.txt")){
			echo "Opening for write ".$language."-only-id.txt\n";
	 		$tmpFile = fopen($language."-only-id.txt",'a+');
	 		fwrite($tmpFile, $tweet_id."\n");
	 		fclose($tmpFile);

	 	}
	 	else{
	 		touch($language."-only-id.txt");
	 		echo "Opening for write ".$language."-only-id.txt";
	 		$tmpFile = fopen($language."-only-id.txt",'a+');
	 		fwrite($tmpFile, $tweet_id."\n");
	 		fclose($tmpFile);

	 	}	
		
	}


?>