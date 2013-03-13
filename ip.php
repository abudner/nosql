<?
require('ip2locationlite.class.php');
echo 'Pobieranie<br>';
$ipLite = new ip2location_lite;
$ipLite->setKey('18ee39bc3e4a78daf71516c815682b210c02e3b10c834ca1456266c40a9b9d5d');
$array = explode("\n", file_get_contents("http://www.nirsoft.net/countryip/pl.csv")); // pobieranie bazy polskich ip
for($i=0;$i<=sizeof($array);$i++) {
	$array[$i] = str_getcsv($array[$i]);   // rozdzielamy dane po przecinku i wrzucamy do $array[$i]
	if(sizeof($array[$i]) < 4 || empty($array[$i]))
		unset($array[$i]);
	
	for($z=5;$z<sizeof($array[$i]);$z++) {
		$array[$i][4] = $array[$i][4] .', '. $array[$i][$z];
	}
	for($z=5;$z<sizeof($array[$i]);$z++) {
		unset($array[$i][$z]);
	}
}
$f = fopen('dane.json', 'w');
for($i=0;$i<sizeof($array);$i++) {
	$locations = $ipLite->getCity($array[$i][0]); //pobieranie po ip
	$arr[$i] = $locations;
	unset($arr[$i]['statusCode']);
	unset($arr[$i]['statusMessage']);	
	unset($arr[$i]['zipCode']);
	
	fwrite($f, json_encode($arr[$i]) . ",\n");
	
	
}

echo 'Zapisano';
fclose($f);
?>
