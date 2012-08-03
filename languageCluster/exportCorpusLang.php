<?php
	include_once '../general/connection.php';
	define('EXPORT_LANG','ES');
	$sql = "select * from dataTweetsLang where language = '".EXPORT_LANG."';";
	$handler = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_array($handler)){
		print_r($row);
	}

?>