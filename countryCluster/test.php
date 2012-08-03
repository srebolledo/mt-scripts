<?php

require_once '/Applications/MAMP//bin/php/php5.3.6/lib/php/Services/GeoNames.php';
require_once '../general/connection.php';
$geonames  = new Services_GeoNames('username', 'some authtoken...');
$countries = $geonames->countryInfo(array('lang' => 'es'));
echo "List of all countries in spanish language:\n";
foreach ($countries as $country) {
    printf(" - %s (capital: %s)\n", $country->countryName, $country->capital);
}

?>
