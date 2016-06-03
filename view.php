<!-- <html head> -->

<?php
session_start();

function convert_time($time){
	//echo $time;
	$ret = "";
	if($time / 86400 >= 1){
		$ret = $ret . floor($time / 86400) ." day ";
		$time %= 86400;
	}
	if($time / 3600 >= 1){
		$ret = $ret . floor($time / 3600) ." hour ";
		$time %= 3600;
	}
	if($time / 60 >= 1){
		$ret = $ret . floor($time / 60) ." minute ";
		$time %= 60;
	}
	//echo ": $ret </br>";

	return $ret;
}

function cmp($a, $b)
{
	if ($a[$_SESSION["sort"]] == $b[$_SESSION["sort"]]) {
		return 0;
	}
	return ($a[$_SESSION["sort"]] < $b[$_SESSION["sort"]]) ? -1 : 1;
}

$ret = json_decode($_SESSION["result"], true);
if(isset($_GET["sort"])) $_SESSION["sort"] = $_GET["sort"];

?>



<!DOCTYPE html>
<html>
<head>
	<title>Route</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/font-awesome/css/font-awesome.min.css">
	<script>
		function myFunction(val) {
		    //alert("The input value has changed. The new value is: " + val);
		    window.location.assign("view.php?sort=" + val);
		}
	</script>
</head>

<?php $cnt = 1; ?>
<body class="background">
	<div class="top" align="center">
		<div style="width: 15%">
				<a align="left" class="btn" href= "index.php" style="margin-top:20px">
					<button class="btn btn-lg" style="background-color: #1e5d78; color: white">HOME</button>
				</a>
		</div>
		<div style="width: 85%; padding-top: 25px">
			<div align="center">Source : <?php echo $_SESSION["src"];?></div>
			<div align="center">Destination : <?php echo $_SESSION["des"];?></div>
			<div align="center">Start Time : <?php echo $_SESSION["start_time"];?></div>
			<div class="form-group" style="display: flex; margin-left: 0px">
				<div style="flex: 1">Sort By :</div>
				<div style="flex: 1">
					<select name="sort" onchange="myFunction(this.value)" class="form-control" style="background-color: #DAF7A6; margin-top: -5px; margin-left: -100px">
					  <option value="tot_time" <?php if($_SESSION["sort"]=="tot_time") echo selected?>>Time</option>
					  <option value="cost" <?php if($_SESSION["sort"]=="cost") echo selected?>>Cost</option>
					  <option value="distance" <?php if($_SESSION["sort"]=="distance") echo selected?>>Distance</option>
					</select>
				</div>
			</div>
		</div>	
	</div>
	
<?php
	if(isset($ret["fail"])){
		?>
			<div class="fail">
				SORRY! NO ROUTE FOUND!
			</div>
		<?php
	}
	else{
		usort($ret, "cmp");
?>

			
	<?php foreach ($ret as $val){ ?>
		<div class = "route container">
			<div class="route-title">
				<i class="fa fa-train"></i>
				ROUTE NO: <?php echo "$cnt" ?>
			</div>

			<div class="detail">
			
				<div> Total Time:  <?php echo convert_time($val["tot_time"]);  ?> </div>
				<div> Total Cost: <?php echo $val["cost"]; ?> BDT</div>
				<div> Total Distance: <?php echo $val["distance"]; ?> KM </div>
			</div>
			
			<?php foreach ($val["vehicle"] as $key => $vcl){?>
			<?php if($key == 0) { ?>
			<div class="header">	
				<div style = "flex : 0.5"> Num</div>
				<div style = "flex : 2"> Name</div>
				<div> Source</div>
				<div> Destination</div>
				<div> Start Time</div>
				<div> Arrival Time</div>
				<div> Cost</div>
				<div> Distance</div>
			</div>
			<?php } ?>
			<div class="individual">
				<div style = "flex : 0.5"> <?php echo $key+1;  ?> </div>
				<div style = "flex : 2"> <?php echo $vcl["name"];  ?> </div>
				<div> <?php echo $vcl["src"];  ?> </div>
				<div> <?php echo $vcl["des"];  ?> </div>
				<div> <?php echo $vcl["start_time"];  ?> </div>
				<div> <?php echo $vcl["arrival_time"];  ?> </div>
				<div> <?php echo $vcl["cost"];  ?> BDT </div>
				<div> <?php echo $vcl["distance"];  ?> KM </div>
			</div>
				
			<?php }?>
		</div>
	<?php $cnt = $cnt + 1; } ?>
	
<?php }?>
</body>
</html>