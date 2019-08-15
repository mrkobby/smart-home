<?php 
session_start();
if (isset($_SESSION["username"])) {
    header("location: hall.php"); 
    exit();
}else if (isset($_SESSION["uname"])){
	 header("location: signup.php"); 
    exit();
}
?><?php
if(isset($_POST["uname"])){
	$uname = $_POST['uname'];
	$pass = $_POST['pass'];
	include_once("system/connection.php");
	$sql = "SELECT id FROM user_account WHERE username='$uname'";
    $query = mysqli_query($db_conx, $sql); 
	$u_check = mysqli_num_rows($query);
	if($uname == "" || $pass == ""){
		echo "login_failed";
        exit();
	} else if ($u_check == 0){ 
        echo "login_failed";
        exit();
	}  else {
		$sql0 = "SELECT id, username, password FROM user_account WHERE username='$uname'";
        $query0 = mysqli_query($db_conx, $sql0);
        $row = mysqli_fetch_row($query0);
		$db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
		if($pass != $db_pass_str){
			echo "login_failed";
            exit();
		} else {
			$_SESSION['id'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("username", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("password", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 
			
			$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
			$sql1 = "UPDATE user_account SET ip='$ip', last_login_date=now() WHERE username='$db_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql1);
			echo $db_username;
		    exit();
		}
	}
	exit();
}
?><?php
if(isset($_POST["adminpass"])){
	$adminpass = $_POST['adminpass'];
	include_once("system/connection.php");
	$sql = "SELECT id FROM user_account WHERE username='admin'";
    $query = mysqli_query($db_conx, $sql); 
	$a_check = mysqli_num_rows($query);
	if($adminpass == ""){
		echo "admin_failed";
        exit();
	} else if ($a_check == 0){ 
        echo "admin_failed";
        exit();
	}  else {
		$sql = "SELECT id, username, password FROM user_account WHERE password='$adminpass' AND type='A'";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
		$ad_id = $row[0];
		$ad_username = $row[1];
        $ad_pass_str = $row[2];
		if($adminpass != $ad_pass_str){
			echo "admin_failed";
            exit();
		} else {
			$_SESSION['adminid'] = $ad_id;
			$_SESSION['uname'] = $ad_username;
			$_SESSION['pass'] = $ad_pass_str;
			
			$ip2 = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
			$sql1 = "UPDATE user_account SET ip='$ip2', last_login_date=now() WHERE username='$ad_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql1);
			echo $ad_username;
		    exit();
		}
	}
	exit();
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

    <title>Login </title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="img/logo.jpg" rel="icon">
</head>
<body>
<div class="container">
   <div class="row">
		<div class="col-md-4 col-sm-12">
			<a href="index.php"><img src="img/logo.jpg"></a>
        </div>
		<div class="login col-md-4 col-sm-12">
			<div class="login-panel panel panel-default">
                <div id="statusheader" class="panel-heading text-center">
                     <span id="status"><h3 class="panel-title">Sign In</h3></span>
                </div>
                <div class="panel-body">
                    <form class="text-center" role="form" method="post" onSubmit="return false;">
                        <fieldset id="normal">
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" onfocus="emptyElement('status')" id="username" name="username" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" onfocus="emptyElement('status')" id="password" name="password" type="password">
                            </div>
                            <span id="loginbtn"><button onclick="login()" class="btn btn-lg btn-primary btn-block">Sign In</button></span>
                        </fieldset>
						<a id="admin_create_acc" href="javascript:void(0)"> <h5> Create user accounts</h5> </a>
						<fieldset style="display:none !important" id="admin">
                            <div class="form-group">
                                <input class="form-control" placeholder="Enter admin password" onfocus="emptyElement('status')" id="adminpass" name="adminpass" type="password">
                            </div>
                            <span id="adminbtn"><a href="javascript:void(0)" onclick="adminValidator()" class="btn btn-md btn-primary btn-block">Proceed</a></span>
                        </fieldset>
						<a id="return_to_mormal" style="display:none !important" href="javascript:void(0)"> <h5> Login as a User</h5> </a>
                    </form>
                </div>
            </div>
		</div>
		<div class="col-md-4 col-sm-12"></div>
	</div>
</div>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/mtc.js"></script>
<script>
$("#admin_create_acc").click(function(){
	$("#normal").slideUp(300);
	$("#admin").fadeIn(300);
	$("#admin_create_acc").slideUp(300);
	$("#return_to_mormal").fadeIn(300);
})
$("#return_to_mormal").click(function(){
	$("#normal").slideDown(300);
	$("#admin").fadeOut(0);
	$("#admin_create_acc").slideDown(300);
	$("#return_to_mormal").fadeOut(0);
})
</script>
<script>
function emptyElement(x){
	getElement(x).innerHTML = '<h3 class="panel-title">Sign In</h3>';
	getElement("statusheader").style.backgroundColor = '#f5f5f5';
}
function login(){
	var uname = getElement("username").value;
	var pass = getElement("password").value;
	if(uname == "" || pass == ""){
		getElement("status").innerHTML = '<h5 class="panel-title">Missing form values</h5>';
		getElement("statusheader").style.backgroundColor = '#efc3c3';
	} else {
		getElement("loginbtn").innerHTML = "Please wait...";
		var ajax = ajaxObj("POST", "index.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					getElement("status").innerHTML = '<h3 class="panel-title">Login failed</h3>';
					getElement("statusheader").style.backgroundColor = '#efc3c3';
					getElement("loginbtn").innerHTML = '<a href="javascript:void(0)" onclick="login()" class="btn btn-lg btn-primary btn-block">Sign In</a>';
				} else {
					window.location = "hall.php";
				}
	        }
        }
       ajax.send("uname="+uname+"&pass="+pass);
	}
}
function adminValidator(){
	var adminpass = getElement("adminpass").value;
	if(adminpass == ""){
		getElement("status").innerHTML = '<h5 class="panel-title">Please enter admin password</h5>';
		getElement("statusheader").style.backgroundColor = '#efc3c3';
	} else {
		getElement("adminbtn").innerHTML = "Please wait...";
		var ajax = ajaxObj("POST", "index.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "admin_failed"){
					getElement("status").innerHTML = '<h3 class="panel-title">Authentication failed</h3>';
					getElement("statusheader").style.backgroundColor = '#efc3c3';
					getElement("adminbtn").innerHTML = '<a href="javascript:void(0)" onclick="adminValidator()" class="btn btn-md btn-primary btn-block">Proceed</a>';
				} else {
					window.location = "signup.php";
				}
	        }
        }
       ajax.send("adminpass="+adminpass);
	}
}
</script>
</body>
</html>
