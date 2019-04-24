<?php

session_start();
$uname = "Administrator";
$uid = 31;
if(isset($_SESSION['usr_type']) =="") {
	header("Location: index.php");
}
$value = "W";



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

$error = false;

//check if form is submitted
if (isset($_POST['user'])) {
	$name = mysqli_real_escape_string($con, $_POST['admin']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
	$from = mysqli_real_escape_string($con, $_POST['from']);
	$content = mysqli_real_escape_string($con, $_POST['content']);
	
	//name can contain only alpha characters and space
	if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
		$error = true;
		$name_error = "Name must contain only alphabets and space";
	}
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$error = true;
		$email_error = "Please Enter Valid Email ID";
	}
	if(strlen($password) < 6) {
		$error = true;
		$password_error = "Password must be minimum of 6 characters";
	}
	if($password != $cpassword) {
		$error = true;
		$cpassword_error = "Password and Confirm Password doesn't match";
	}
	if (!$error) {
		//For Mailing
			$to = $from; 
			$email_subject = "Communication from MinD Webs Team (web.mindwebs.org)";
			$email_body = $content;
	
			$headers = "From: administrator@mindwebs.org\n"; 
			$headers .= "Reply-To: $email";
	
	
			mail($to,$email_subject,$email_body,$headers);
			
		//Update of mail database
			if(mysqli_query($con, "INSERT INTO admin_mail(user,reciver,subject,content) VALUES('" . $name . "', '" . $email . "', '" . $email_subject . "', '" .$content . "')")) {
				if(mysqli_query($con, "UPDATE users SET password = '" . md5($pass_new) . "' WHERE email = '" . $email. "'")) {
					$sucessmsg = "Work executed sucessfully";
				}
			} else {
				$errormsg = "Task could not be completed!!! Please Try again later...";
			}
		
	}
}

include_once 'dbconnect.php';
?>



<!doctype html>
<html>
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <script language="JavaScript" src="js/gen_validatorv31.js" type="text/javascript"></script>
    <title>MinD Webs - Admin Panel</title>
    
    <!-- Font Awesome -->
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">    
    <!-- Slick slider -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css"/> 
    <!-- Fancybox slider -->
    <link rel="stylesheet" href="assets/css/jquery.fancybox.css" type="text/css" media="screen" /> 
    <!-- Animate css -->
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css"/> 
    <!-- Progress bar  -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-progressbar-3.3.4.css"/> 
     <!-- Theme color -->
    <link id="switcher" href="assets/css/theme-color/default-theme.css" rel="stylesheet">

    <!-- Main Style -->
    <link href="style.css" rel="stylesheet">

    <!-- Fonts -->

    <!-- Open Sans for body font -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <!-- Lato for Title -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>    
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">MinD Webs</a>
		</div>
		
			<ul class="nav navbar-nav navbar-right">
				<?php if (isset($_SESSION['usr_id'])) { ?>
				<li><p class="navbar-text">Signed in as <?php echo $_SESSION['usr_name']; ?></p></li>
				<li><a href="logout.php">Log Out</a></li>
				<?php } else { ?>
				<li><a href="login.php">Login</a></li>
				<li><a href="newuser.php">Sign Up</a></li>
				<?php } ?>
			</ul>
		
	</div>
</nav>

<section id="contact">
     <div class="container">
       <div class="row">       
         <div class="col-md-12">
           <div class="cotact-area">
             <div class="row">              
               <div class="col-md-8">
                 <div class="contact-area-right">
                 <?php
				 if ((($_SESSION['usr_type']) == $value) ){ ?>
                 <form method="POST" name="user" action="<?php echo $_SERVER['PHP_SELF']; ?>"  >
                 	<legend>Update User Details</legend>
                   <p>Administrator Full Name</p>
                    <div class="form-group">                        
                      <input type="text" name="admin" disabled class="form-control" placeholder="Administrator Full Name" value = "<?php echo $_SESSION['usr_name']; ?> " required>
                    </div>
                    <p>Email of Account Holder</p>
                    <div class="form-group">                        
                      <input type="email" name="email" class="form-control" placeholder="Account Email" required>
                    </div>
                    <p>Email of Sender</p>
                     <div class="form-group">                        
                      <input type="email" name="from" disabled class="form-control" placeholder="Email of Sender" value="mindwebsteam@gmail.com" required>
                    </div>
                    <p>Password (A Random Password is Generated, Change it If you want)</p>
                    <div class="form-group">                        
                      <input type="text" name="password" class="form-control" placeholder="" value="<?php echo $pass_new ?>"required>
                      <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                     </div>
                     <p>Confirm Password</p>
                     <div class="form-group">                        
                      <input type="password" name="cpassword" class="form-control" placeholder="" value="" required>
                      <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
                    </div>
                    <p>Any Message For The User</p>
                    <div class="form-group">                        
                      <textarea placeholder="" name="content" rows="5" class="form-control" required >Your Password Has been changed to : <?php echo $pass_new ?> for security purposes... Please login to the site with this new password and change your password again as per your requirement...<?php echo "\n" ?></textarea>
                    </div>
                     
                    <p>Get an copy of Mail at</p>
                     <div class="form-group">                        
                      <input type="email" name="copy" class="form-control" placeholder="Get an copy of Mail at" >
                    </div>
                    
                    <button class="btn btn-primary" type="submit" value="Submit" >Update System</button>
                    <button class="btn btn-primary" style="float:right" type="reset" value="reset" >Reset Form</button>
                    
                  </form>
                  <br><br>
                  <button class="btn btn-primary" type="" value="" ><a href="list.php" target="_blank" style="color:#fff">View List Of Users</a></button>
                  <?php } else {
					  echo nl2br("You are Not Having Eligible Permissions... \n");
					  echo nl2br("Please Log in Again with Appropriate rights... \n");
					  echo nl2br("If you want to know more, please drop us a mail at : mindwebsteam@gmail.com ");
					  
				  } ?>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
  </section>
  
   <div id="footer" style="display: inline-block;position:absolute;min-height: 40px;bottom: 0px;padding-top:10px;color:#fff;width: 100%;background-color: #27ae60">
    	<ul class="fleft">
        	© MinD Webs Team | Designed by Dipan Roy | Hosted and Maintained by MinD Webs Team
        </ul>
</div
</body>
</html>