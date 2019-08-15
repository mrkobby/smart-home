<?php
$light_state = $_GET['temp'];

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
$sql2 = "INSERT INTO light(lightState,time) VALUES ($lightState,now());";


if ($conn->query($sql2) === TRUE) {
    echo "Temperature Saved Successfully!";
} else {
    echo "Error:" . $sql2 . "<br>" . $conn->error;
}

$conn->close();
?>