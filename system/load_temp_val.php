<?php
include_once("connection.php");
?><?php
$temperature = "";
$sql = "SELECT temperature FROM dht11 ORDER BY id DESC LIMIT 1";
$query = mysqli_query($db_conx, $sql);
while($row = mysqli_fetch_array($query)){ 
   $temperature = $row["temperature"];
}
echo $temperature;
?>