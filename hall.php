<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location: index.php"); 
    exit();
}
$id = preg_replace('#[^0-9]#i', '', $_SESSION["id"]);
$username = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["username"]);
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]);
include_once("system/connection.php");
$sql = mysqli_query($db_conx, "SELECT * FROM user_account WHERE id='$id' AND username='$username' AND password='$password' LIMIT 1");
$existCount = mysqli_num_rows($sql);
if ($existCount == 0) { 
	 echo "Your login session data is not on record in the database.";
     exit();
}
?><?php
$sql = mysqli_query($db_conx, "SELECT * FROM user_account WHERE username='$username'");
while($row = mysqli_fetch_array($sql)){ 
   $id = $row["id"];
   $name = $row["name"];
   $username = $row["username"];
   $login_time = strftime("%b %d, %Y at %I:%M %p", strtotime($row["last_login_date"]));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard </title>
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
   <li class="active"><a href="index.php">Home</a></li> 
   <li><a href="report.php">View report</a></li> 
   <li><a href="logout.php"><span class="fa fa-power-off"></span> Logout</a></li> 
</ul> 
<div class="container-fluid">
   <div class="row">
        <div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
							 <li class="active pull-right"><a href="hall.php"> <?php echo $login_time;?> </a></li>
							 <li class="active pull-right"><a href="hall.php"> You are logged in as <?php echo $name;?> </a></li>
                        </ul>		
						<div class="panel panel-default">
                        <!-- <div class="panel-heading">
                            Hall Appliances
                        </div> -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" style="margin-bottom: 0px;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sensors</th>
                                            <th>State</th>
                                            <th>Time</th>
                                            <!--<th>Report</th>-->
                                            <th>Turn On/ Off</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Temperature</td>
                                            <td><span id="temp_val">0</span>&deg; Celsius </td>
                                            <td><span class="hum_val_time"><div class="loader" style="width: 20px;height: 20px;margin: 0;"></div></span></td>
                                            <!--<td><a href="report.php">View report</a></td>-->
                                            <!--  <td><a href="http://192.168.0.100" class="btn btn-sm btn-primary btn-block" style="width:100px">On/Off</a></td>          -->
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Light</td>
                                            <td></td>
                                            <td><span><!--00:00--></span></td>
                                            <td><a href="http://192.168.1.101/" class="btn btn-sm btn-primary btn-block" style="width:125px">Turn light On/Off</a></td>
                                            <!--<td><div class="togglebutton"><label><input type="checkbox"></label></div></td>-->
                                        </tr>
										<tr>
                                            <td>3</td>
                                            <td>Humidity</td>
                                            <td><span id="hum_val">00</span>%</td>
                                            <td><span class="hum_val_time"><div class="loader" style="width: 20px;height: 20px;margin: 0;"></div></span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>
	</div>
</div>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/material-kit.js"></script>
<script src="js/material.min.js"></script>
<script src="js/mtc.js"></script>
<script>
$.ajaxSetup({cache:false});
setInterval(function(){$('#temp_val').load('system/load_temp_val.php');}, 1000)
$.ajaxSetup({cache:false});
setInterval(function(){$('#hum_val').load('system/load_hum_val.php');}, 1000)
$.ajaxSetup({cache:false});
setInterval(function(){$('.hum_val_time').load('system/load_time.php');}, 1000)
</script>
</body>
</html>
