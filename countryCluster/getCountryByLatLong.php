<?php

	require_once '../general/connection.php';
	require_once '/Applications/MAMP//bin/php/php5.3.6/lib/php/Services/GeoNames.php';
	$sql = "select tweet_id,field7,field6 from dataTweetESLocalized where location = ''";
	$handler = mysql_query($sql);
	$geonames = new Services_GeoNames();
	$i = 0;
	while($row = mysql_fetch_array($handler)){
		$lat = $row['field6'];
		$long = $row['field7'];
		$country = $geonames->findNearby(array(
			'lat' => $lat,
			'lng' => $long,
		)
	);
		$country = objectToArray($country);
		$country = trim($country[0]['countryName']);
		$sql = "update dataTweetESLocalized	 set location = '".$country."' where tweet_id = ".$row['tweet_id'];
		mysql_query($sql);
		$i++;
		// echo "                                                                                                  \r";
		echo "$i) Actualizando locación de tweet_id ".$row['tweet_id']." a ".$country."\n";

	}
	echo "\n";
	
	
function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}

?>
