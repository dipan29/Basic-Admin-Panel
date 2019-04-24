<?php
session_start();
if(isset($_SESSION['usr_id'])=="") {
	header("Location: index.php");
}
$value = 'W';
include_once 'dbconnect.php';
?>
<!--<!doctype html>-->
<html>
<head>
<meta charset="utf-8">
<title>MinD Webs - Admin Panel</title>
<link rel="stylesheet"  type="text/css" href="styles/global.css" />

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
                    <?php
				 		if (($_SESSION['usr_type']) != "G") { ?>
                    <li><a class="selected"href="#">Check Users Login</a></li>
                    <?php } ?>
                    <li><a  href="memo.php">Create a New MEMO </a></li>
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
        	<h2>Dashboard</h2>
             
             <div id="box">
            	<div class="box-top">Users Login</div>
                <div class="box-panel" style="overflow:scroll; height: 260px;">
                	<?php
					if(($_SESSION['usr_type']) != "G") {
						$result = mysqli_query($con, "SELECT * FROM users_file");
					}
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo "Username : " . $row["username"]. "<br>Email : " . $row["email"]. "<br>Registered At : " . $row["registered_at"]. " <br>Last Login : " . $row["last_login"]. " <br>Last Password Changed : " . $row["last_pass"]. "<br><hr>"; }
					} else {
							echo "No Records Found to display or <br>Some technical error occured, please refresh.";
					}
					?>
                </div>
             </div>
             <br>
             <br>
        </div>
    </div>
   
    <div id="footer">
    	<ul class="fleft">
        	© MinD Webs Team | Designed by Dipan Roy | Hosted and Maintained by MinD Webs Team
        </ul>
        <ul class="fright">
        	Last Logged in at: <?php echo $_SESSION['usr_time']; ?>
        </ul>
     </div>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>