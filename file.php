<?php
include_once 'db.php';
include_once 'addVehicleAction.php';

drop_db();
create_db();

echo "</hr>";
echo "</br>";

$myfile = fopen("data.txt", "r") or die("Unable to open file!");
// Output one line until end-of-file
while(!feof($myfile)) {
	$line = trim(fgets($myfile));
	if($line == "") continue;
	if($line == "end") break;
	echo "read Line: $line</br>";
	
	$name = strtok($line, " \n\t");
	$src = strtok(" \n\t");
	$des = strtok(" \n\t");
	$start_time = strtok(" \n\t") . " " . strtok(" \n\t");
	$arrival_time = strtok(" \n\t"). " " . strtok(" \n\t");
	$cost = strtok(" \n\t");
	$distance = strtok(" \n\t");
	
// 	while ($tok !== false) {
// 		echo "Word=$tok<br />";
// 		$tok = strtok(" \n\t");
// 	}

	echo "name: $name src: $src des: $des start_time: $start_time arrival_time: $arrival_time cost:$cost distance: $distance </br>";
	$vehicle = new Vehicle($name, $src, $des, $start_time, $arrival_time, $cost, $distance);
}

while(!feof($myfile)){
	$line = trim(fgets($myfile));
	if($line == "") continue;
	$sql = "INSERT INTO location(location_name) VALUES ('$line')";
	runSql($sql);
}

fclose($myfile);