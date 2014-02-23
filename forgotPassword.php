<?php

include_once 'Constants.php';
include_once 'User.php';
include_once 'UserServices.php';
include_once 'Mailer.php';

ob_start();
session_start();


if(isset($_SESSION['userId']) ){
	header("Location: " . APP_USER_LOGIN_SUCCESS_URL);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
	<title>Testing Forgot Password</title>
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap.css' />
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap-responsive.css' />
	<link rel='stylesheet' type='text/css' href='commonCss.css' />

</head>

<body>

	<div class='container topRightMenu'>
		<p class='right'><a href='login.php'>Login</a> | <a href='register.php'>Register</a> | <a href='home.php'>Back</a></p>
		<div class='clearFloat'></div>
	</div>

	<div class='container' id='forgotPasswordFormErrors' align='center'>
	</div>

<?php

if(isset($_POST['submitted']) ){
	//echo "Form Submitted " . PHP_EL ;
	$email = $_POST['email'];
	//$us = new UserServices();
	//$pass = $us->getPassword($email);
	$pass = true ;
	if($pass){
		$randomPassword = "lpp@" . rand() ;
		$user = new User($email, $randomPassword, "Local");
		if($user->changePassword($randomPassword) ){
			// Send mail
			$body = "<font color='gray' size='3px' face='tahoma'>";
            $body .= "Hi" . ",<br/><br/>Greetings from LetsPokerPlan Automated System.<br><br>";
            $body .= " Your password has been reset to the new password as shown below:<br> " ;
            $body .= "<br><b><i>" . $randomPassword . "</i></b>";
            $body .= "<br/><br/>" ;
            $body .= "Please change this password as soon as possible, after logging using this auto generated password." ;
            $body .= "<br/><br/>" ;
            $body .= "Thanks & Regards<br/><b>Lets Poker Plan</b>";
            $body .= "</font>" ;
            date_default_timezone_set('UTC');
    		$curr_date = date(DATE_RFC822);
            $subject = "Thanks for using Recover Password service with LetsPokerPlan @ " . $curr_date ;
            $mailer = Mailer::getInstance();
            $from = "admin@fitied.com" ;
            if($mailer->sendMail($email, $from, $subject, $body)){
            	echo "<div class='container' align='center'><span class='makebigger label label-info'>
					Your new password has been sent to you via e-mail.<br><br>
					Please change the auto-generated password by logging with it as soon as possible.
				</span><hr></div>" ;
            }else{
            	// Email not send properly. :(
            	echo "<div class='container' align='center'><span class='makebigger label label-info'>
					We are sorry that we could not sent you the email with new password to you at this time. Please re-try.
				</span><hr></div>" ;
				$logger_ = FileLogger::getInstance("forgotPassword.php");
				$logger_->log(LogLevel::$ERROR, " Could not send email after successful password reset for email : " . $email);
            }
			
			exit(0);
		}else{
			echo "<div class='container' align='center'><span class='makebigger label label-warning'>Failed to recover your password at this time. Please try after some time.</span><hr></div>" ;
		}
	}else{
		echo " Some thing fissy going on....." . PHP_EL ;
		exit(0);
	}
	echo $email . PHP_EL ;
	
}else{
	//echo "Not submitted " . PHP_EL ;
 }

?>

	<div class='container topSection' align='center'>
		<h1>Recover Password System</h1>
		<div class='loginWindow'>
			<form action='forgotPassword.php' method='post' name='forgotPasswordForm' onsubmit='return isforgotPasswordFormFilledCorrectly();'>

				<table>
					<tr>
						<td><span>Email</span></td>
						<td>&nbsp;&nbsp;<input id='email' type='email' name='email' value="<?php if(isset($_POST['email'])){ echo $_POST['email'] ; } ?>" placeholder='Type your Email Id' required/></td>
						<td>&nbsp;&nbsp;<span id='emailValidity'><img src='red_circle.png' style='width: 20px; height: 20px;'/></span></td>
					</tr>
				</table>
				<br>
				<input type='hidden' name='submitted' class='hidden'/>
				<input type='submit' class='btn btn-primary' value='Recover Password' />
			</form>
		</div>

	</div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="jquery.placeholder.js"></script>
<script type='text/javascript' src='commonJs.js'></script>

</body>

</html>