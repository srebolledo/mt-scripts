<?php
	require_once '../general/connection.php';
	$sql = "select * from hashtags";
	$handler = mysql_query($sql);
	while($row = mysql_fetch_array($handler)){
		$hashtag = $row["hashtag"];
		$hashtag_id = $row["id"];
		$sql = "SELECT * FROM tweets_new WHERE tweet LIKE '%$hashtag%'";
		$r2 = mysql_query($sql);
		while($row2 = mysql_fetch_array($r2)){
			$tweet_id = $row2["id"];
			$sql = "insert into hashtags_tweets values (NULL,$hashtag_id, $tweet_id";
			mysql_query($sql);
		}
		$sql = "update hashtags set tweet_count = ".count(mysql_num_rows($r2));
		mysql_query($sql);

	}

?>