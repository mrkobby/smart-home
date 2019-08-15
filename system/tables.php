<?php
include_once("connection.php");
$tbl_user_account = "CREATE TABLE IF NOT EXISTS user_account (
              id INT(11) NOT NULL AUTO_INCREMENT,
			  type ENUM('U','A') NOT NULL DEFAULT 'U',
			  name VARCHAR(255) NULL,
			  username VARCHAR(16) NULL,
			  password VARCHAR(255) NULL,
			  creation_date DATETIME NOT NULL,
			  last_login_date DATETIME NOT NULL,
			  ip VARCHAR(255) NOT NULL,
              PRIMARY KEY (id),
			  UNIQUE KEY email (username,id)
             )";
$query = mysqli_query($db_conx, $tbl_user_account);
if ($query === TRUE) {echo "<h6 style='color:green;'>user_account table created OK :) </h6>"; } else {echo "<h6 style='color:red;'>user_account table NOT created :( </h6>"; }

$insertsql = "INSERT INTO user_account (type, name, username, password, creation_date, last_login_date) VALUES ('A','admin','admin','admin',now(),now())";
$insertquery = mysqli_query($db_conx, $insertsql);
if ($insertquery === TRUE) {echo "<h6 style='color:blue;'>user_account table filled with admin data :) </h6>"; } else {echo "<h6 style='color:red;'>user_account table NOT filled with admin data :( </h6>"; }

?>