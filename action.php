<?php
session_start();
include_once 'db.php';

$route = new Route($_POST["source"], $_POST["destination"], $_POST["start_time"]);

$_SESSION["src"] = $_POST["source"];
$_SESSION["des"] = $_POST["destination"];
$_SESSION["start_time"] = $_POST["start_time"];
$_SESSION["sort"] = $_POST["sort"];

if($_POST["source"] != $_POST["destination"]) $ret = find_route($route);
if($ret){
	//print_r($ret);
	
	$_SESSION["result"] = json_encode($ret);
	
}
else{
	$_SESSION["result"] = json_encode(["fail" => "NO route found"]);
	
}
echo "</br> ok </br>";


header("Location: view.php");
exit;

function find_route($route){
	$q = new SplQueue();
	$q->push($route);
	$ret = array();
	while(!$q->isEmpty()){

		$route = $q->top();
		$q->pop();
		
		if($route->src != $route->des){
			$vehicles = find_vehicles($route->src);

			$routes = addRoutes($route, $vehicles);
			
			foreach ($routes as $rut){
				$q->push($rut);
			}
		}
		else{
			array_push($ret, $route);
// 			echo "route found : ";
// 			$route->printVehicles();
// 			echo "</br>";
		}		
	}
	return $ret;
}

function addRoutes($route, $vehicles){
	$ret = array();
	foreach ($vehicles as $vcl){
		$tmpRoute = clone $route;
		if($tmpRoute->isVehicleUsable($vcl)){
			$tmpRoute->useVehicle($vcl);
			
			array_push($ret, $tmpRoute);
		}
	}
	//print_r($ret);
	return $ret;
}


class Route{
	public $src, $des, $src_time, $tot_time=0, $distance=0, $cost=0;
	public $vehicle_name = [];
	public $vehicle = [];
	public $city = [];

	public function __construct($start, $des, $time){
		$this->src = $start;
		$this->des = $des;
		$this->src_time = $time;
		$this->city[$start] = true;
		//echo "start: " . $this->src . " destination: " . $this->des .  " time: " . $this->src_time . "</br>";
	}

	public function  isVehicleUsable($vcl){
		return !(isset($this->vehicle_name[$vcl["name"]]) || isset($this->city[$vcl["des"]]));
	}

	public function useVehicle($vcl) {
		$this->vehicle_name[$vcl["name"]] = true;
		$this->city[$vcl["des"]] = true;
		
		array_push($this->vehicle, $vcl);
		$this->tot_time += $this->time_diff($this->src_time, $vcl["start_time"]);
		$this->tot_time += $this->time_diff($vcl["start_time"], $vcl["arrival_time"]);
		
		//echo $this->tot_time;

		$this->src = $vcl["des"];
		$this->src_time = $vcl["start_time"];
		$this->distance += $vcl["distance"];
		$this->cost += $vcl["cost"];
	}
	
	private function time_diff($pres, $end){
		//echo $pres . " " . $end . " ";
		$pres = strtotime($pres);
		$end = strtotime($end);
		$diff = $end - $pres;
		//echo $diff . "</br>";
		if($diff <= 0) return $diff + 24*3600;
		else return $diff;
	}
	
	public function printVehicles() {
		echo "</br> </br> </br> printing result </br>";
// 		foreach ($this->vehicle_name as $key => $val){
// 			echo "$key </br>";
// 		}
		
		foreach ($this->vehicle as $vcl){
			print_r($vcl);
		}
		echo "</br> print vehicle finish </br>";
	}
}


