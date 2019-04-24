<?php
session_start();
if(isset($_SESSION['usr_id'])=="") {
	header("Location: index.php");
}

if(($_SESSION['usr_type'])=='G' ) {
	
		header("Location: index.php");
}

$value = "W";

include_once 'dbconnect.php';

//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['signup'])) {
	$text = mysqli_real_escape_string($con, $_POST['text']);
	$subject = mysqli_real_escape_string($con, $_POST['subject']);
	$type = mysqli_real_escape_string($con, $_POST['type']);
		
	
	if (!$error) {
		if(mysqli_query($con, "INSERT INTO admin_memo(user,subject,type,text) VALUES('" . $_SESSION['usr_name'] . "', '" . $subject . "', '" . $type . "','" . $text . "')")) {
			$successmsg = "Successfully Generated Memo!!!";
		} else {
			$errormsg = "Error in generating...Please try again!";
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
                    <li><a class="selected" href="#">Create a New MEMO </a></li>
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
        	<h2>Create A New MEMO</h2>
            <br><br>
            <!--FORM SECTION -->
            
            <div class="form">
		
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform"> 
            
    			<p class="contact"><label for="subject">Subject</label></p> 
    			<input class="subject" id="subject" name="subject" placeholder="Give A Short Description" required="" tabindex="1" type="text" required> 
    			 
    			<p class="contact"><label for="content">Content</label></p> 
    		    <textarea class="textarea-m" id ="textareaa" placeholder="Content" name="text" rows="8" tabindex="2" required></textarea>
                
            <fieldset> 
             <label class = "main-l">Visible After</label> 
             <select  class="select-style" tabindex="3" name="type" required>
             <option value="G">Guest</option>
             <option disabled value="">Select Type</option>
             <option value="W">Web Master</option>
             <option value="A">Administrator</option>
             <option value="E">Editor</option>
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
            
            <input class="btn-login" name="signup" id="submit" tabindex="4" value="Submit Memo!" type="submit"> 	 
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