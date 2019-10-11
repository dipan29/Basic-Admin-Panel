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

$errors = '';
$link_address = 'https://mindwebs.org';
$myemail = 'to email id here';
if(empty($_POST['admin'])  || 
   empty($_POST['email']) || 
   empty($_POST['from']) || 
   empty($_POST['subject']) || 
   empty($_POST['content']) || 
   empty($_POST['reply']))
{
    $errors .= "\n Error: all fields are required";
}

$admin = $_POST['admin']; 
$email = $_POST['email'];
$from = $_POST['from']; 
$subject = $_POST['subject'];
$content = $_POST['content']; 
$reply = $_POST['reply']; 
$copy = $_POST['copy']; 

if (!preg_match(
"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", 
$email))
{
    $errors .= "\n Error: Invalid email address";
}


if( empty($errors))
{
	if(mysqli_query($con, "INSERT INTO admin_mail(user,reciver,subject,content) VALUES('" . $admin . "', '" . $email . "', '" . $subject . "', '" .$content . "')")) {
	$to = $email; 
	$email_subject = $subject;
	$email_body = $content; 
	
	$headers = "From: $from\n"; 
	$headers .= "Reply-To: $reply";
	
	$headers2 = "From: administrator@abc.com \n"; 
	$headers2 .= "Reply-To: $reply";
	
	mail($to,$email_subject,$email_body,$headers);
	//redirect to the 'thank you' page
	echo nl2br("Mail Sucess \n");
	echo "Back to ";
	echo '<a href="'.$link_address.'">Home</a>';
	
	mail($myemail,$email_subject,$email_body,$headers2);
	
	if($copy != "") {
		mail($copy,$email_subject,$email_body,$headers);
	} 
	//<!-- End for admin update -->
	
} else {
		$errormsg = "Could Not Send Mail";
	
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
	<title>Mail form handler</title>
</head>

<body>
<!--This page is displayed only if there is some error ->>
<?php
echo nl2br($errors);
echo nl2br($errormsg);
?>


</body>
</html>
