<?php
	define('LANGUAGE', 'EN');
	define('CORPUS_TWEETS_ALL','tweets-all-corpus-with-nulls.csv');
	$file_id = fopen('processed/'.LANGUAGE.'-only-id.txt', 'r');
	$cd = getcwd();
	chdir("../../data-tweets/");
	$i = 1;
	while(!feof($file_id)){
		$tweet_id = trim(fgets($file_id));
		echo "$i - Searching for id: ".$tweet_id."\n";
		$tweet_data = exec('grep '.$tweet_id. ' '.CORPUS_TWEETS_ALL);
		echo $tweet_data."\n";
		$i++;

	}
?>