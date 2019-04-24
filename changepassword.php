<?php
session_start();
if(isset($_SESSION['usr_id'])=="") {
	header("Location: index.php");
}
$value = 'W';
include_once 'dbconnect.php';


$sucessmsg="";
$email_address = 'mindwebsteam@gmail.com';

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

$pass_new = randomPassword();

if (isset($_POST['changep'])) {

	$email = mysqli_real_escape_string($con, $_POST['email']);
	$dob = mysqli_real_escape_string($con, $_POST['dob']);
	$passold = mysqli_real_escape_string($con, $_POST['passold']);
	$pnew = mysqli_real_escape_string($con, $_POST['pnew']);
	$pconf = mysqli_real_escape_string($con, $_POST['pconf']);
	$result = mysqli_query($con, "SELECT * FROM admin WHERE dob = '" . $dob. "' and email = '" . $email . "' and password = '" . md5($passold) . "' ");
	

	if ($row = mysqli_fetch_array($result)) {
		{
			if((mysqli_query($con, "UPDATE admin SET password = '" . md5($pnew) . "' WHERE id = '" . $_SESSION['usr_id'] . "'")) && $pnew==$pconf && $email==$_SESSION['usr_email'])  	{
				$sucessmsg = "Password Changed Sucessfully";
				header("Location: logout.php");
			}
		}
	} else {
		$errormsg = "Mismatch of Provided Information";
	}
	
	
}

?>

<!--<!doctype html>-->
<html>
<head>
<meta charset="utf-8">
<title>MinD Webs - Admin Panel</title>
<link rel="stylesheet"  type="text/css" href="styles/global.css" />
<link rel="stylesheet"  type="text/css" href="styles/forms.css" />
<meta  name= "viewport" content="width=device-width, initial-scale: 1.0, user-scalable=0" />
<script src = "js/jquery-3.2.1.min.js"></script>
<script src = "js/general.js"></script>


</head>

<body>

	<div id = "header"> 
    	<div class="logo">
        	<a href="index.php">MinD<span> Webs</span></a>
         </div>
         <ul class="login">
				<?php if (isset($_SESSION['usr_id'])) { ?>
				<li><p class="navbar-text">Signed in as <?php echo $_SESSION['usr_name']; ?></p></li>
				<?php } ?>
         </ul>
    </div>
    
    <a class="mobile" href="#">MENU</a>
    	
  
    
    <div id="container">
    	<div class="sidebar">
        	<ul id = "nav">
            		<li><a href="home.php">Dashboard</a></li>
                	<li><a href="update.php">Update User Profile</a></li>
                	
                    <li><a class="selected" href="#">Change Password</a></li>
                    <li><a href="user.php">Check Users Login</a></li>
                    <li><a href="memo.php">Create a New MEMO </a></li>
                    <li><a href="viewmail.php">Check Mail</a></li>
                    <li><a href="mail.php">Generate New Mail</a></li>
                    <?php
				 		if (($_SESSION['usr_type']) == $value) { ?>
                    <li><a href="updateuser.php">Update User Details</a></li>
                    <?php } ?>
					<?php
				 		if ((($_SESSION['usr_type']) == $value) || (($_SESSION['usr_type']) == "A")){ ?>
                    <li><a href="newuser.php">Create New User</a></li>
                    <?php } ?>
                    <li><a href="logout.php">Log Out</a></li>
            </ul>    
            
        </div>
        <div class="content">
        	<h2>Create A New Password</h2>
            <br><br>
            <!--FORM SECTION -->
            
            <div class="form">
		
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="changepform">
				<fieldset>
					<legend>Change Password</legend>
                    <br>
					
						<p class="contact"><label for="subject">Email ID</label></p>
						<input type="email" name="email" placeholder="Your Email" required class="" />
					
						<p class="contact"><label for="dob">Date of Birth</label></p>
						<input type="text" name="dob" placeholder="dd/mm/yyyy" required class="" />
                        
                        <p class="contact"><label for="passold">Your old password</label></p>
						<input type="password" name="passold" placeholder="" required class="" />
						
                        <p class="contact"><label for="passold">Your New password</label></p>
						<input type="password" name="pnew" placeholder="" required class="" />
                        <p class="contact"><label for="passold">Confirm Your New password</label></p>
						<input type="password" name="pconf" placeholder="" required class="" />
                        <br>
                        <input class="btn-login" name="changep" id="submit" tabindex="6" value="Change Password!" type="submit"> 
					
				</fieldset>
			</form>
			<span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } else { echo $sucessmsg ;}  ?></span>
		
	</div>
            
        </div>
    </div>
    
    <div id="footer">
    	<ul class="fleft">
        	© MinD Webs Team | Designed by Dipan Roy | Hosted and Maintained by MinD Webs Team
        </ul>
        <ul class="fright">
        	Logged in From : <?php echo $_SESSION['usr_time']; ?>
        </ul>
    </div>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>