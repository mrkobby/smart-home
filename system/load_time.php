<?php
include_once("connection.php");
?><?php
$time = "";
$sql = "SELECT time FROM dht11 ORDER BY id DESC LIMIT 1";
$query = mysqli_query($db_conx, $sql);
while($row = mysqli_fetch_array($query)){ 
   $time = strftime("%I:%M %p", strtotime($row["time"]));
}
echo $time;
?>