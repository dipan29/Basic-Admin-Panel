<?php
session_start();
if(isset($_SESSION['usr_id'])=="") {
	header("Location: index.php");
}

if(($_SESSION['usr_type'])!='W' ) {
	if(($_SESSION['usr_type'])!='A')
		header("Location: index.php");
}

$value = "W";

include_once 'dbconnect.php';

//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['signup'])) {
	$name = mysqli_real_escape_string($con, $_POST['name']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
	$dob = mysqli_real_escape_string($con, $_POST['BirthDay']) . "/" . mysqli_real_escape_string($con, $_POST['BirthMonth']) . "/" . mysqli_real_escape_string($con, $_POST['BirthYear']);
	$type = mysqli_real_escape_string($con, $_POST['type']);
	$admin = $name . "User Registration Done By : " . $_SESSION['usr_name'];
	
	$subject = "Registration at MinD Webs (mindwebs.org)";
	$content = "Thank You for registering with Us. We hope your journey with us will be a great one \nHere are the details of registration:\n Name: $name \n Email: $email \n Password : $password (Store it in a safe place)\n Link : admin.mindwebs.org"; 
	
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
		if(mysqli_query($con, "INSERT INTO admin(name,email,password,dob,type,registered_by) VALUES('" . $name . "', '" . $email . "', '" . md5($password) . "', '" .$dob . "', '" .$type . "','" .$_SESSION['usr_name'] . "')")) {
		if(mysqli_query($con, "INSERT INTO admin_mail(user,reciver,subject,content) VALUES('" . $admin . "', '" . $email . "', '" . $subject . "', '" .$content . "')")) {
			$to = $email; 
			$email_subject = "Registration at MinD Webs (mindwebs.org)";
			$email_body = "Thank You for registering with Us. We hope your journey with us will be a great one \n".
			" Here are the details of registration:\n Name: $name \n Email: $email \n Password : $password (Store it in a safe place)\n Link : admin.mindwebs.org"; 
	
			$headers = "From: $email_address\n"; 
			$headers .= "Reply-To: $email_address";
	
		
			mail($to,$email_subject,$email_body,$headers);
			$successmsg = "Successfully Registered!!!";
			} else {	$errormsg = "Error in registering...Please try again later!";	}
			
		} else {
			$errormsg = "Error in registering...Please try again later!";
		}
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
                	
                    <li><a href="changepassword.php">Change Password</a></li>
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
                    <li><a class="selected" href="#">Create New User</a></li>
                    <?php } ?>
                    <li><a href="logout.php">Log Out</a></li>
            </ul>    
            
        </div>
        <div class="content">
        	<h2>Create New User</h2>
            <br><br>
            <!--FORM SECTION -->
            
            <div class="form">
		
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform"> 
            
    			<p ><label for="name">Name</label></p> 
    			<input id="name" class="label-form" name="name" placeholder="First and last name" required="" tabindex="1" type="text"> 
    			 
    			<p "><label for="email">Email</label></p> 
    			<input id="email" class="label-form name="email" placeholder="example@domain.com" required="" tabindex="2" type="email"> 
                
                    			 
                <p ><label for="password">Create a password</label></p> 
    			<input type="password" class="label-form" id="password" name="password" tabindex="3" required=""> 
                <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                <p ><label for="repassword">Confirm your password</label></p> 
    			<input type="password" class="label-form" id="cpassword" name="cpassword" tabindex="4" required=""> 
                <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
        
 				       
               <fieldset>
               <p ><label for="bday">Birth Date</label></p> 
               <label class="main-l"><input class="birth" maxlength="2" name="BirthDay"  placeholder="Day" tabindex="6" required=""></label>
                  <label class="main-l"></label>
                  <label class="month"> 
                  <select class="select-style" name="BirthMonth" tabindex="5">
                  <option value="">Select Month</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03" >March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12" >December</option>
                  </label>
                 </select>    
                
                <label class="main-l"> <input class="birth" maxlength="4" name="BirthYear" placeholder="Year" tabindex="7" required=""></label>
            	
                 
              <br>
             
             <label class = "month">User Type</label> 
             <select  class="select-style" tabindex="8" name="type">
             <option disabled value="">Select Type</option>
             <option value="W">Web Master</option>
             <option value="A">Administrator</option>
             <option value="E">Editor</option>
             <option value="G">Guest</option>
             </select>
               </fieldset>
             
 <!-- 
            <select class="select-style gender" name="gender">
            <option value="select">i am..</option>
            <option value="m">Male</option>
            <option value="f">Female</option>
            <option value="others">Other</option>
            </select>
    -->       
    <br>
            <label ">Mobile phone Number</label> 
            <input id="phone" class = "label-form name="phone" placeholder="Phone Number" tabindex="9" required="" type="text"> <br>
            <br>
            <input class="btn-login" name="signup" id="submit" tabindex="10" value="Register User!" type="submit"> 	 
   </form> 
			<span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
			<span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
		
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