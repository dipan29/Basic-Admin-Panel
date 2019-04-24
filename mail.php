<?php
session_start();
$uname = "Administrator";
$uid = 31;
if(isset($_SESSION['usr_id']) =="") {
	header("Location: index.php");
}
$value = "W";

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
    <title>MinD Webs - Mail</title>
    
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
				 if ((($_SESSION['usr_type']) == $value) || (($_SESSION['usr_type']) == "A") ){ ?>
                 <form method="POST" name="mailform" action="sendmail.php">
                   <form action="#" class="comments-form contact-form">
                   <p>Administrator Full Name</p>
                    <div class="form-group">                        
                      <input type="text" name="admin" class="form-control" placeholder="Administrator Full Name" value = "<?php echo $_SESSION['usr_name']; ?> " required>
                    </div>
                    <p>Email of Reciever</p>
                    <div class="form-group">                        
                      <input type="email" name="email" class="form-control" placeholder="Email of Reciever" required>
                    </div>
                    <p>Email of Sender</p>
                     <div class="form-group">                        
                      <input type="email" name="from" class="form-control" placeholder="Email of Sender" value="mindwebsteam@gmail.com" required>
                    </div>
                    <p>Subject</p>
                    <div class="form-group">                        
                      <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                     </div>
                    <p>Content</p>
                    <div class="form-group">                        
                      <textarea placeholder="Content" name="content" rows="5" class="form-control" required></textarea>
                    </div>
                     <p>Email of Reply Inbox</p>
                     <div class="form-group">                        
                      <input type="email" name="reply" class="form-control" placeholder="Email of Reply Inbox" value="mindwebsteam@gmail.com" required>
                    </div>
                    <p>Get an copy of Mail at</p>
                     <div class="form-group">                        
                      <input type="email" name="copy" class="form-control" placeholder="Get an copy of Mail at" >
                    </div>
                    
                    <button class="comment-btn" type="submit" value="Submit" >Send Mail</button>
                    <button class="comment-btn" type="reset" value="reset" >Reset Form</button>
                    
                    </form>
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
  
 <!--
 <div id="footer" style="display: inline-block;position:absolute;min-height: 40px;bottom: 0px;padding-top:10px;color:#fff;width: 100%;background-color: #27ae60">
    	<ul class="fleft">
        	© MinD Webs Team | Designed by Dipan Roy | Hosted and Maintained by MinD Webs Team
        </ul>
</div>
 -->
</body>
</html>