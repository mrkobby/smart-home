<?php 
session_start();
if (!isset($_SESSION["uname"])) {
    header("location: index.php"); 
    exit();
}
include_once("system/connection.php");
?><?php
if (isset($_POST["delete"]) && $_POST["userid"] != "" && $_POST['delete'] == "user"){
	$userid = preg_replace('#[^0-9]#', '', $_POST["userid"]);
	$query = mysqli_query($db_conx, "SELECT * FROM user_account WHERE id='$userid' LIMIT 1");
	$rows = mysqli_num_rows($query);
	
	$sql0 = "DELETE FROM user_account WHERE id='$userid' LIMIT 1";
	$query = mysqli_query($db_conx, $sql0);
	mysqli_close($db_conx);
	echo "deleted_ok";
	exit();
}
?><?php
if (isset($_POST["admin"]) && $_POST["id"] != "" && $_POST['admin'] == "adduser"){
	$id = preg_replace('#[^0-9]#', '', $_POST["id"]);
	$query = mysqli_query($db_conx, "SELECT * FROM user_account WHERE id='$id' LIMIT 1");
	$rows = mysqli_num_rows($query);
	
	$sql1 = "UPDATE user_account SET type='A' WHERE id='$id' LIMIT 1";
	$query = mysqli_query($db_conx, $sql1);
	mysqli_close($db_conx);
	echo "admin_ok";
	exit();
}
?><?php
$user_list = "";
$sql = "SELECT * FROM user_account";
$user_query = mysqli_query($db_conx, $sql);
$numrows = mysqli_num_rows($user_query);
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
		$user_id = $row["id"];
		$type = $row["type"];
		$name = $row["name"];
		$username = $row["username"];
		
		$user_admin = '<button onclick="makeAdmin(\''.$user_id.'\',\'mkbtn_'.$user_id.'\');" class="btn btn-sm btn-info btn-block">Make Admin</button>';
		if($type == "A"){
			$user_admin = '<button class="btn btn-sm btn-success btn-block" disabled>Admin</button>';
		}else if($type == "U"){
			$user_admin = '<button onclick="makeAdmin(\''.$user_id.'\',\'mkbtn_'.$user_id.'\');" class="btn btn-sm btn-info btn-block">Make Admin</button>';
		}
		
		$user_list .= '<tr id="user_'.$user_id.'"><td>'.$user_id.'</td><td>'.$type.'</td><td>'.$name.'</td><td>'.$username.'</td>';
		$user_list .= '<td><button onmousedown="deleteUser(\''.$user_id.'\',\'user_'.$user_id.'\');" class="btn btn-sm btn-danger btn-block">Delete</button></td>';
		$user_list .= '<td id="mkbtn_'.$user_id.'">'.$user_admin.'</td></tr>';		                                 
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

    <title>Admin - Users </title>
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
   <li><a href="index.php">Add user</a></li> 
   <li class="active"><a href="users.php">All users</a></li> 
   <li><a href="logout.php"><span class="fa fa-power-off"></span> Sign out</a></li> 
</ul> 
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2 col-sm-12"></div>
		<div class="col-md-8 col-sm-12">
			<div class="panel-body">
				<div class="panel panel-default">
				  <div class="panel-body">
					<div class="table-responsive">
					  <table class="table table-hover">
						<thead>
						  <tr>
							<th>Id</th>
							<th>Type</th>
							<th>Name</th>
							<th>Username</th>
							<th></th>
							<th></th>
						  </tr>
						</thead>
						<tbody>
						  <?php echo $user_list;?>
						</tbody>
					  </table>
					</div>
				  </div>
				</div>
			</div>
		  </div>
		<div class="col-md-2 col-sm-12"></div>
	</div>
</div>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/mtc.js"></script>
<script>
function deleteUser(userid,user){
	var conf = confirm("Press OK to confirm the delete action on this user.");
	if(conf != true){
		return false;
	}else{
	var ajax = ajaxObj("POST", "users.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "deleted_ok"){
				alert("User has been deleted successfully.");
				getElement(user).style.display = "none";
			}
		}
	}
	ajax.send("delete=user&userid="+userid);
	}
}
function makeAdmin(userid,mkbtn){
	var conf = confirm("Press OK to confirm this action");
	if(conf != true){
		return false;
	}else{
	var ajax = ajaxObj("POST", "users.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "admin_ok"){
				getElement(mkbtn).innerHTML = '<button class="btn btn-sm btn-success btn-block" disabled>Admin</button>';
			}
		}
	}
	ajax.send("admin=adduser&id="+userid);
	}
}
</script>
</body>
</html>
