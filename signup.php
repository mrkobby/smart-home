<?php 
session_start();
if (!isset($_SESSION["uname"])) {
    header("location: index.php"); 
    exit();
}
?><?php
if(isset($_POST["fname"])){
	include_once("system/connection.php");
	$fname = $_POST['fname'];
	$uname = $_POST['uname'];
	$pass = $_POST['pass'];
	$sql = "SELECT id FROM user_account WHERE username='$uname'";
    $query = mysqli_query($db_conx, $sql); 
	$u_check = mysqli_num_rows($query);
	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	if($fname == "" || $uname == "" || $pass == ""){
		echo '<h4 class="panel-title">Missing form values</h4>';
        exit();
	} else if ($u_check > 0){ 
        echo '<h4 style="font-size: 16px;" class="panel-title">The username already exists</h4>';
        exit();
	}  else if ($uname == "admin") {
        echo '<h6 style="font-size: 14px;" class="panel-title">Please use a different username </h6>';
        exit(); 
    }  else if (strlen($uname) < 3 || strlen($uname) > 16) {
        echo '<h6 style="font-size: 14px;" class="panel-title">Username must be between 3 and 10 characters. </h6>';
        exit(); 
    }else{
		$sql_insert = "INSERT INTO user_account (type, name, username, password, creation_date, ip)       
		        VALUES('U','$fname','$uname','$pass',now(),'$ip')";
		$query = mysqli_query($db_conx, $sql_insert); 
		$uid = mysqli_insert_id($db_conx);
		echo "create_success";
        exit();
	}
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

    <title>Sign Up </title>
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
   <li class="active"><a href="index.php">Hello Administrator!</a></li> 
   <li><a href="users.php">View all users</a></li> 
   <li><a href="logout.php"><span class="fa fa-power-off"></span> Sign out</a></li> 
</ul> 
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-sm-12"></div>
		<div class="create col-md-4 col-sm-12">
			<div class="login-panel panel panel-default">
                <div id="statusheader" class="panel-heading text-center">
                    <span id="status"><h3 class="panel-title">Add new a user account</h3></span>
                </div>
                <div class="panel-body">
                    <form class="text-center" role="form" method="post" onSubmit="return false;">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Full name" onfocus="emptyElement('status')" id="fname" name="fname" type="text" autofocus>
                            </div>
							<div class="form-group">
                                <input class="form-control" placeholder="Username" onfocus="emptyElement('status')" id="uname" name="uname" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" onfocus="emptyElement('status')" id="pass1"  name="pass1" type="password">
                            </div>
							<div class="form-group">
                                <input class="form-control" placeholder="Confirm password" onfocus="emptyElement('status')" id="pass2" name="pass2" type="password">
                            </div>
                            <span id="signupbtn"><button onclick="createAcc()" class="btn btn-lg btn-info btn-block">Create</button></span>
                        </fieldset>
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
function emptyElement(x){
	getElement(x).innerHTML = '<h3 class="panel-title">Create an account</h3>';
	getElement("statusheader").style.backgroundColor = '#f5f5f5';
}
function createAcc(){
	var fname = getElement("fname").value;
	var uname = getElement("uname").value;
	var pass1 = getElement("pass1").value;
	var pass2 = getElement("pass2").value;
	if(uname == "" || fname == "" || pass1 == ""){
		getElement("status").innerHTML = '<h5 class="panel-title">Missing form values</h5>';
		getElement("statusheader").style.backgroundColor = '#efc3c3';
	} else if(pass1 != pass2){
		getElement("status").innerHTML = '<h5 class="panel-title">Your passwords do not match</h5>';
		getElement("statusheader").style.backgroundColor = '#efc3c3';
	} else {
		getElement("signupbtn").innerHTML = "Please wait...";
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText != "create_success"){
					getElement("status").innerHTML = ajax.responseText;
					getElement("statusheader").style.backgroundColor = '#efc3c3';
					getElement("signupbtn").innerHTML = '<a href="javascript:void(0)" onclick="createAcc()" class="btn btn-lg btn-primary btn-info">Create</a>';
				} else {
					getElement("status").innerHTML = '<h5 class="panel-title" style="color:green;">Account was created successfully</h5>';
					getElement("statusheader").style.backgroundColor = '#f5f5f5';
					getElement("signupbtn").innerHTML = '<a href="javascript:void(0)" onclick="createAcc()" class="btn btn-lg btn-primary btn-info">Create</a>';
					var fname = getElement("fname").value = "";
					var uname = getElement("uname").value = "";
					var pass1 = getElement("pass1").value = "";
					var pass2 = getElement("pass2").value = "";
				}
	        }
        }
       ajax.send("fname="+fname+"&uname="+uname+"&pass="+pass1);
	}
}
</script>
</body>
</html>
