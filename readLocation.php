<?php
	require_once("dbcontroller.php");
	$db_handle = new DBController();
	
	if(!empty($_POST["keyword"])) {
		$query ="SELECT * FROM location WHERE location_name like '" . $_POST["keyword"] . "%' ORDER BY location_name LIMIT 0,6";
		$result = $db_handle->runQuery($query);
		if(!empty($result)) {
		?>
		<ul id="location-list">
		<?php
			foreach($result as $location) {
		?>
		<li onClick="selectlocation('<?php echo $location["location_name"]; ?>');"><?php echo $location["location_name"]; ?></li>
		<?php } ?>
		</ul>
	<?php } } 
?>