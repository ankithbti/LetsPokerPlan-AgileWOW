<?php

include_once 'Constants.php';
include_once 'User.php';
include_once 'Mailer.php';

ob_start();
session_start();


if(isset($_SESSION['userId']) ){
	header("Location: " . APP_USER_LOGIN_SUCCESS_URL);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
	<title>Testing Register</title>
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap.css' />
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap-responsive.css' />
	<link rel='stylesheet' type='text/css' href='commonCss.css' />
</head>

<body>

	<div class='container topRightMenu'>
		<p class='right'><a href='login.php'>Login</a> | <a href='forgotPassword.php'>Forgot Password</a> | <a href='home.php'>Back</a></p>
	</div>

	<div class='container' id='registerFormErrors' align='center'>
	</div>

<?php

if(isset($_POST['submitted']) ){
	//echo "Form Submitted " . PHP_EL ;
	$email = $_POST['email'];
	$pass = $_POST['mypass'];
	$cpass = $_POST['cpass'];
	if(strcmp($pass, $cpass) != 0){
		echo "<div class='container' align='center'><span class='makebigger label label-warning'>" . "Password does not match with the confirm password. Please register again." . "</span><hr></div>" ;
	}else{
		//echo "Email : " . $email . " Password : " . $pass . PHP_EL ;
		$user = new User($email, $pass, "Local");
		// //echo $user . PHP_EL ;
		if($user->register()){

			$activationLink = "http://www.fitied.com/letspokerplan/activateAccount.php?userId=" . $user->getId() ;
			$body = "<font color='gray' size='3px' face='tahoma'>";
            $body .= "Hi" . ",<br/><br/>Greetings from LetsPokerPlan Automated System.<br/><br/>";
            $body .= " Thanks for registering with us.<br/> Please click on the below link to activate your account:" ;
            $body .= "<br><a href='" . $activationLink . "' target='_blank'>Click to activate</a>";
            $body .= "<br/><br/>" ;
            $body .= "Thanks & Regards<br/><b>Lets Poker Plan</b>";
            $body .= "</font>" ;
            date_default_timezone_set('UTC');
    		$curr_date = date(DATE_RFC822);
            $subject = "Thanks for registering with LetsPokerPlan @ " . $curr_date ;
            $mailer = Mailer::getInstance();
            $from = "admin@fitied.com" ;
            if($mailer->sendMail($email, $from, $subject, $body)){
            	echo "<div class='container' align='center'><span class='makebigger label label-info'>
					User registered successfully.<br><br>An e-mail has been sent to you with an activation link. Please click on that link to activate your account.
				</span><hr></div>" ;
            }else{
            	// Email not send properly. :(
            	echo "<div class='container' align='center'><span class='makebigger label label-info'>
					User registered successfully. But we are sorry that we could not sent you the email with activation link. Will contact you soon for assistance. Till then Chill out!!!!!
				</span><hr></div>" ;
				$logger_ = FileLogger::getInstance("Register.php");
				$logger_->log(LogLevel::$ERROR, " Could not send email after successful registration for email : " . $email);
            }
            exit(0);
		}else{
			echo "<div class='container' align='center'><span class='makebigger label label-warning'>" . $user->getRegError() . "</span><hr></div>" ;
		}
	}
	
}else{
	//echo "Not submitted " . PHP_EL ;
 }

?>

	<div class='container topSection' align='center'>
		<h1>Registration System</h1>
		<div class='registerWindow'>
			<form action='register.php' method='post' name='registerForm' onsubmit='return isRegisterFormFilledCorrectly();'>

				<table>
					<tr>
						<td><span>Email</span></td>
						<td>&nbsp;&nbsp;<input id='email' type='email' name='email' value="<?php if(isset($_POST['email'])){ echo $_POST['email'] ; } ?>" placeholder='Type your Email Id' required/></td>
						<td>&nbsp;&nbsp;<span id='emailValidity'><img src='red_circle.png' style='width: 20px; height: 20px;'/></span></td>
					</tr>
					<tr>
						<td><span>Password</span></td>
						<td>&nbsp;&nbsp;<input id='mypass' type='password' name='mypass' required/></td>
						<td>&nbsp;&nbsp;<span id='passwordValidity'><img src='red_circle.png' style='width: 20px; height: 20px;'/></span></td>
					</tr>
					<tr>
						<td><span>Confirm Password</span></td>
						<td>&nbsp;&nbsp;<input id='cpass' type='password' name='cpass' required/></td>
						<td>&nbsp;&nbsp;<span id='confirmPasswordValidity'><img src='red_circle.png' style='width: 20px; height: 20px;'/></span></td>
					</tr>
				</table>

				<br>
				<input type='hidden' name='submitted' />
				<input type='submit' class='btn btn-primary' value='Register' />
				
			</form>
		</div>
		<span class='makesmallbigger smallmarginfromtop label'>Password should be of length between 6-16 characters. It should have atleast one numberic and one special character.</span>
	</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="jquery.placeholder.js"></script>
<script type='text/javascript' src='commonJs.js'></script>

</body>

</html>