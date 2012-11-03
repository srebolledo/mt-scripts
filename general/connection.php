<?php
	$user = 'root';
	$pass = '';
	$host = 'localhost';
	//$host = ':/Applications/MAMP/tmp/mysql/mysql.sock';
	$database = 'twitter';
	$link = mysql_connect($host,$user,$pass);

	if(!$link){
		echo "couldn't connect";
		die();
	}
	mysql_select_db($database,$link);
	mysql_set_charset('utf8',$link); 

?>	