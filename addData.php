<?php
$temp = $_GET['temp'];
$hum = $_GET['hum'];
//$fan = "Fan OFF"

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smarthome";

// Create connection
$conn = new mysqli($servername, $username,$password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//$val = $_GET['temp'];
$sql = "INSERT INTO dht11(temperature,humidity,time) VALUES ($temp,$hum,now());";
/* $sql0 = "SELECT COUNT(id) FROM dht11";
$query0 = mysqli_query($db_conx, $sql0); 
$row = mysqli_fetch_row($query0);
if ($row[0] > 29) { 
	$sql1 = "SELECT id FROM dht11 ORDER BY id ASC";
   	$query1 = mysqli_query($db_conx, $sql1); 
	$row2 = mysqli_fetch_row($query1);
	$oldest = $row2[0];
	mysqli_query($db_conx, "DELETE FROM dht11 WHERE id='$oldest'");
} */

if ($conn->query($sql) === TRUE) {
    echo "Temperature Saved Successfully!";
} else {
    echo "Error:" . $sql . "<br>" . $conn->error;
}

$conn->close();

//localhost/smart_home/addData.php
?>