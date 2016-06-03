<html>
<head>
<TITLE>ROUTE</TITLE>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

</head>

<body class="background">
	
	<div class="frmSearch">
		<form action="action.php" method="post">
			<div class="source form-group-lg">
				<label for="Source">Source</label>
				<input type="text" id="search-box" name="source" placeholder="Starting from" class="form-control">
				<div id="suggesstion-box" class="hid"></div>
			</div>
			
			<div class="destination form-group-lg">
				<label for="destination">Destination</label>
				<input type="text" id="search-box2" name="destination" placeholder="Ending at" class="form-control">
				<div id="suggesstion-box2" class="hid"></div>
			</div>

			<div class="time form-group-lg" align="center">
				<label for="start_time">Start Time</label>
				<input type="text" name="start_time" placeholder="HH:MM AM/PM" class="form-control">
				<div id="suggesstion-box2" class="hid"></div>
			</div>
			<div class="time form-group-lg" align="center">
				<label for="sort_by">Sort By</label>
				<select name="sort" class="form-control" style="background-color: #DAF7A6">
				  <option value="tot_time">Time</option>
				  <option value="cost">Cost</option>
				  <option value="distance">Distance</option>
				</select>
			</div>
			<!-- <button> Find Route </button> <br> -->
			<div class="butStyle" align="center">
				<button class="btn btn-success" style="padding: 12px 120px;">
					Find Route
				</button>
			</div>
		</form>
	</div>
</body>


<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$("#search-box").keyup(function(){
		$.ajax({
		type: "POST",
		url: "readLocation.php",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#search-box").css("background","#FFF");
		}
		});
	});
});

function selectlocation(val) {
	$("#search-box").val(val);
	$("#suggesstion-box").hide();
}
</script>

<script>
$(document).ready(function(){
	$("#search-box2").keyup(function(){
		$.ajax({
		type: "POST",
		url: "readLocation2.php",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#search-box2").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-box2").show();
			$("#suggesstion-box2").html(data);
			$("#search-box2").css("background","#FFF");
		}
		});
	});
});

function selectlocation2(val) {
	$("#search-box2").val(val);
	$("#suggesstion-box2").hide();
}
</script>
</html>

<!--  -->
