<?php
include_once("connection.php");
?><?php
$report = "";
$sql = "SELECT * FROM dht11";
$query = mysqli_query($db_conx, $sql);
$report .= '<table class="table table-hover"><thead><tr><th>#</th><th>Temperature</th><th>Humidity</th><th>Time</th>';
$report .= '</tr> </thead><tbody>';
while($row = mysqli_fetch_array($query)){ 
   $id = $row["id"];
   $humidity = $row["humidity"];
   $temperature = $row["temperature"];
   $time = strftime("%I:%M %p", strtotime($row["time"]));
   //$time = strftime("%d-%m-%Y at %I:%M %p", strtotime($row["time"]));
   
   $sql0 = "SELECT COUNT(id) FROM dht11";
$query0 = mysqli_query($db_conx, $sql0); 
$row = mysqli_fetch_row($query0);
if ($row[0] > 8) { 
	$sql1 = "SELECT id FROM dht11 ORDER BY id ASC";
   	$query1 = mysqli_query($db_conx, $sql1); 
	$row2 = mysqli_fetch_row($query1);
	$oldest = $row2[0];
	mysqli_query($db_conx, "DELETE FROM dht11 WHERE id='$oldest'");
}
   
 $report .= '';
   $report .= '<tr style="text-align:center;"><td>'.$id.'</td><td>'.$temperature.'&deg;C </td><td>'.$humidity.'%</td><td>'.$time.'</td><tr>';
}       
 $report .= '</tbody>';
$report .= '</table>';                                                                                                                
echo $report;
?>