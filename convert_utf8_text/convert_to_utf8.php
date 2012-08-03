<?php
	var_dump($argv);
	$filename = $argv[1];
	echo $filename;
	$f = fopen($filename, "r");
	$out = fopen("out-".$filename,"w+");
	while($line = fgets($f)){
		 $line = utf8_decode($line);
		 fwrite($out,$line);
	}
	fclose($f);
	fclose($out);

?>