<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

if(isset($_SESSION['usr_id'])!="") {
	header("Location: home.php");
}

include_once 'dbconnect.php';

//check if form is submitted
if (isset($_POST['login'])) {

	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$result = mysqli_query($con, "SELECT * FROM admin WHERE email = '" . $email. "' and password = '" . md5($password) . "'");
	$t = time();
	if(mysqli_query($con, "UPDATE admin SET log_in = now() WHERE email = '" . $email. "' and password = '" . md5($password) . "' ")){
	
		if ($row = mysqli_fetch_array($result)) {
		$_SESSION['usr_id'] = $row['id'];
		$_SESSION['usr_name'] = $row['name'];
		$_SESSION['usr_email'] = $row['email'];
		$_SESSION['usr_type'] = $row['type'];
		$_SESSION['usr_time'] = $row['log_in'];
		header("Location: index.php");
		} else {
		$errormsg = "Incorrect Email or Password!!!";
		}
	}
}
?>


<html>
<head>
<meta charset="utf-8">
<title>MinD Webs - Admin Panel Login</title>
<link rel="stylesheet"  type="text/css" href="styles/global.css" />
<meta  name= "viewport" content="width=device-width, initial-scale: 1.0, user-scalable=0" />
<link rel="stylesheet" href="styles/bootstrap.min.css" type="text/css" />
<script src = "js/jquery-3.2.1.min.js"></script>
<script src = "js/general.js"></script>

</head>

<body>

	<div id = "header"> 
    	<div class="logo">
        	<a class="navbar-brand" href="#">MinD Webs</a>
         </div>
    </div>
    
    
    	
  
    <br><br><br><br><br>
    <div id="container">
        <div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
				<fieldset>
					<legend>Login</legend>
					
					<div class="form-group">
						<label for="name">Email</label>
						<input type="text" name="email" placeholder="Your Email" required class="form-control" />
					</div>

					<div class="form-group">
						<label for="name">Password</label>
						<input type="password" name="password" placeholder="Your Password" required class="form-control" />
					</div>

					<div class="form-group">
						<input type="submit" name="login" value="Login" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
		</div>
        
        <div class="row">
			<div class="col-md-4 col-md-offset-4 text-center">	
				New User? <a href="requser.php">Create a Signup Request Here</a>
            </div>
            <br>
            <div class="col-md-4 col-md-offset-4 text-center">
               	Forgot Password? <a href="#">Ask Webmaster for Password Change</a>
			</div>
		</div>
    </div>
    
<div id="footer">
    	<ul class="fleft">
        	© MinD Webs Team | Designed by Dipan Roy | Hosted and Maintained by MinD Webs Team
        </ul>
        <ul class="fright">
        	You are not Logged In.. Please Login to Continue
        </ul>
    </div>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>