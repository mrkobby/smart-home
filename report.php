<?php
include_once("system/connection.php");
?><?php
$temp = array();
$hum = array();
$time = array();
$sql = "SELECT temperature,humidity,time FROM dht11 ORDER BY id LIMIT 5";
$query = mysqli_query($db_conx, $sql);
while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
   array_push($temp, $row["temperature"]);
   array_push($hum, $row["humidity"]);
  array_push($time, strftime("%I:%M %p", strtotime($row["time"])));
}                                                                                                                       
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Report </title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="img/logo.jpg" rel="icon">
</head>
<body>
<div class="container">
   <div class="row">
		<div class="col-md-8 col-sm-12">
			<a href="index.php"><img src="img/logo.jpg"></a>
        </div>
	</div>
</div>
<ul class="nav nav-tabs" style="float: right;margin-top: -70px;margin-bottom: 5px;"> 
   <li><a href="index.php">Home</a></li> 
   <li class="active"><a href="report.php">View report</a></li> 
   <li><a href="logout.php"><span class="fa fa-power-off"></span> Logout</a></li> 
</ul> 
<div class="container-fluid">
   <div class="row">
        <div class="col-lg-7">
			<div class="panel panel-default">
                    <div class="panel-body">	
						<div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
								<div class="widget">
                            <div class="widget-header">
                                <i class="icon-bar-chart"></i>
                                <h3>Line Chart For Readings</h3><br />
                            </div>
                            <div class="widget-content">
                                <canvas id="area-chart" class="chart-holder" width="538" height="250"></canvas>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
				</div>		
            </div>
        </div> 
		<div class="col-lg-5">
				<div class="panel panel-default">
                    <div class="panel-body">	
						<div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
								<span id="report_stuff">
									<div class="loader"></div>
								 </span>
                            </div>
                        </div>
                    </div>
				</div>
					
            </div>
        </div>
    </div> 
</div>
<script src="js/jquery.js"></script>
<script>
$.ajaxSetup({cache:false});
setInterval(function(){$('#report_stuff').load('system/load_report.php');}, 2000);
</script>
<script src="js/chart.min.js"></script>
<script type="text/javascript">
var g = "<?php foreach($hum as $result) { echo $result, ',';}?>";
//alert(g);
var lineChartData = {
			labels: [<?php foreach($time as $t) { echo '"'.$t, '",';}?>],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    pointColor: "rgba(220,220,220,1)",
				    pointStrokeColor: "#fff",
				    data: [<?php foreach($hum as $result) { echo $result, ',';}?>]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    pointColor: "rgba(151,187,205,1)",
				    pointStrokeColor: "#fff",
				    data: [<?php foreach($temp as $res) { echo $res, ',';}?>]
				}
			]

        }
var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);
		
var pieData = [
				{
				    value: 30,color: "#F38630"
				},
				{
				    value: 50,color: "#E0E4CC"
				},
				{
				    value: 100,color: "#69D2E7"
				}

			];

var myPie = new Chart(document.getElementById("pie-chart").getContext("2d")).Pie(pieData);
	</script>
</body>
</html>
