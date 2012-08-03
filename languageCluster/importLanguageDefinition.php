<?php
	require_once '../general/connection.php';
	$languageDefinition = fopen("../../data-tweets/twDCC_lang.txt",'r');
	$lines = 0;
	while(!feof($languageDefinition)){
		$line = trim(fgets($languageDefinition));
		$line = explode("|",$line);
		$id = $line[0];
		$lang = $line[1];
		if(isset($id) && isset($lang)){
			$sql = "INSERT INTO `ner-twitter`.`languageDefinitions` (`id`, `language`) VALUES ($id, '$lang');";
			//echo $sql."\n";
			mysql_query($sql);
			$lines++;
			echo "                                           \r";
			echo "Importadas ".$lines." del archivo\r";

		}
		//echo $line."\n";
	}
?>