<?php
session_start();

if(isset($_SESSION['usr_id'])!="") {
	header("Location: home.php");
}
$errormsg="";

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

$key = randomPassword();

include_once 'dbconnect.php';

$link_address = 'http://web.mindwebs.org';
$myemail = 'mindwebsteam@gmail.com';


//check if form is submitted
if (isset($_POST['signup'])) {

	$name = mysqli_real_escape_string($con, $_POST['name']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$phone = mysqli_real_escape_string($con, $_POST['phone']);
	$dob = mysqli_real_escape_string($con, $_POST['dob']);
	$interest = mysqli_real_escape_string($con, $_POST['interest']);
	$message = mysqli_real_escape_string($con, $_POST['about']);
	$gender = mysqli_real_escape_string($con, $_POST['gender']);
	
	$user = $name . "New Generation of User";
	$content2 = "Thank You for your interest in MinD Webs\nOur Admins will contact you soon\nFurther communication will be done throught Mail or SMS\n\nKeep this key for fututre Reference:  " . $key . "\n\nThank You\nMinD Webs Team";
	
	$subject = "New User Generation ". $email;
	
	if (empty($_POST['name'])  || 
   		empty($_POST['email']) || 
   		empty($_POST['password']) || 
  		empty($_POST['phone']) || 
   		empty($_POST['dob']) || 
   		empty($_POST['about']))
		{
    		$errors .= "\n Error: all fields are required";
		}
	
	$content = "Here are the details submitted by : " . $name . "\nWith Email ID : " . $email . "\nPhone Number : " . $phone  . "\nDate of Birth : " . $dob . "\nGender : " . $gender . "\n\nIntrests :::\n" . $interest . "\n\nMessage :::\n" . $message . "\n\n\nGenerated Key: " . $key . "";
	
	if( empty($errors))
	{
	if(mysqli_query($con, "INSERT INTO admin_mail(user,reciver,subject,content) VALUES('" . $user . "', '" . $myemail . "', '" . $subject . "', '" . $content . "')")) {
		$to = $email; 
		$email_subject = $subject;
		$email_body = $content2; 
	
		$headers = "From: $myemail\n"; 
		$headers .= "Reply-To: $myemail";
	
		$headers2 = "From: administrator@mindwebs.org \n"; 
		$headers2 .= "Reply-To: no-reply@mindwebs.org";
	
		mail($to,$email_subject,$email_body,$headers);
		
		mail($myemail,$email_subject,$content,$headers2);
		
			$sucessmsg = "Mail Sent Sucessfully...\nCheck Your Inbox for further procedure...";
	
			} else {
			$errormsg = "Could Not Generate Request... Please Try Again Later";
		}
	}
	
	/*
	$t = time();
	if(mysqli_query($con, "UPDATE admin SET log_in = now() WHERE email = '" . $email. "' and password = '" . md5($password) . "' ")){
	
		if ($row = mysqli_fetch_array($result)) {
		$_SESSION['usr_id'] = $row['id'];
		$_SESSION['usr_name'] = $row['name'];
		$_SESSION['usr_type'] = $row['type'];
		$_SESSION['usr_time'] = $row['log_in'];
		header("Location: index.php");
		} else {
		$errormsg = "Incorrect Email or Password!!!";
		}
	}
	*/

}
?>


<html>
<head>
<meta charset="utf-8">
<title>MinD Webs - Request For Registration</title>
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
    
    
    	
  
    <br>
    <div id="container">
        <div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signup">
				<fieldset>
					<legend>Sign Up for MinD Webs</legend>
					
                    <div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" placeholder="Your Full Name" required class="form-control" />
					</div>
                    
					<div class="form-group">
						<label for="name">Email</label>
						<input type="text" name="email" placeholder="Your Email" required class="form-control" />
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" placeholder="Your Password" required class="form-control" />
					</div>
                    
					<div class="form-group">
						<label for="phone">Phone Number</label>
						<input type="text" name="phone" placeholder="Your Phone Number (It should be valid, otherwise it will be cancelled)" required class="form-control" />
					</div>
                    
                    <div class="form-group">
						<label for="gender">Your Gender : </label>
                        <select name="gender">
  							<option value="Male">Male</option>
 							<option value="Female">Female</option>
  							<option value="Other">Other</option>
                         </select>
                    </div>
                    <div class="form-group">
						<label for="dob">Date Of Birth</label>
						<input type="text" name="dob" placeholder="dd/mm/yyyy" required class="form-control" />
					</div>
                    <div class="form-group">
                    <fieldset id="interest">
						<label for="interest">Your Area Of Interests : </label>
						<input type="radio" name="interest" value="Web or Grapic Designing"> Web or Grapic Designing
                        <input type="radio" name="interest" value="Phography/Videography"> Phography/Videography <br>
                        <input type="radio" name="interest" value="Blogging/Vblogging"> Blogging/Vblogging  
                        <input type="radio" name="interest" value="Content Providers"> Content Providers 
                        <input type="radio" name="interest" value="Marketing"> Marketing and Management
                        <p>We request you to submit different applications if you have two or more interests."</p>
                    </fieldset>
					</div>
                    
                    <div class="form-group">
						<label for="about">Write in short about yourself, Why you want to join us!!!</label>
						<textarea rows="5" required class="form-control" name="about" placeholder="Your Main Message. <?php echo"\n" ?>Write your interests, your hobbies... Write about yourself"></textarea>
					</div>
                    
					<div class="form-group">
						<input type="submit" name="signup" value="Request for Registration" class="btn btn-primary" />
                        <input type="reset" name="reset" value="Reset Form" style="float:right" class="btn btn-primary" />
					</div>
                    
                    
				</fieldset>
			</form>
            <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } else { echo $sucessmsg ;}  ?></span>
			
		</div>
        
        <div class="row">
			<div class="col-md-4 col-md-offset-4 text-center">	
				Already Registered? <a href="index.php">Login Here</a>
            </div>
            <br>
            
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