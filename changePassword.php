<?php

include_once 'Constants.php';
include_once 'User.php';

ob_start();
session_start();


if(! isset($_SESSION['userId']) ){
	header("Location: login.php" );
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
		<p class='right'> <span class='makelittlebigger label label-success'>Welcome <?php echo $_SESSION['userEmail'] ; ?></span> | <a href='home.php'>Home</a> | <a href='logout.php'>Logout</a></p>
	</div>

	<div class='container' id='changePasswordFormErrors' align='center'>
	</div>

<?php

if(isset($_POST['submitted']) ){
	//echo "Form Submitted " . PHP_EL ;
	$email = $_SESSION['userEmail'] ;
	$userId = $_SESSION['userId'] ;
	$pass = $_POST['mypass'];
	$cpass = $_POST['cpass'];
	if(strcmp($pass, $cpass) != 0){
		echo "<div class='container' align='center'><span class='makebigger label label-warning'>" . "Password does not match with the confirm password. Please try again." . "</span><hr></div>" ;
	}else{
		//echo "Email : " . $email . " Password : " . $pass . PHP_EL ;
		$user = new User($email, $pass, "Local");

		// //echo $user . PHP_EL ;
		if($user->changePassword($pass) ){
			echo "<div class='container' align='center'><span class='makebigger label label-info'>
				Successfully updated your password.
			</span><hr></div>" ;
			
			exit(0);
		}else{
			echo "<div class='container' align='center'><span class='makebigger label label-warning'>Failed to update your password.</span><hr></div>" ;
		}
	}
	
}else{
	//echo "Not submitted " . PHP_EL ;
 }

?>

	<div class='container topSection' align='center'>
		<h1>Change Password System</h1>
		<div class='registerWindow'>
			<form action='changePassword.php' method='post' name='changePasswordForm' onsubmit='return isChangePasswordFormFilledCorrectly();'>

				<table>
					<tr>
						<td><span>New Password</span></td>
						<td>&nbsp;&nbsp;<input id='mypass' type='password' name='mypass' required/></td>
						<td>&nbsp;&nbsp;<span id='passwordValidity'><img src='red_circle.png' style='width: 20px; height: 20px;'/></span></td>
					</tr>
					<tr>
						<td><span>Confirm New Password</span></td>
						<td>&nbsp;&nbsp;<input id='cpass' type='password' name='cpass' required/></td>
						<td>&nbsp;&nbsp;<span id='confirmPasswordValidity'><img src='red_circle.png' style='width: 20px; height: 20px;'/></span></td>
					</tr>
				</table>

				<br>
				<input type='hidden' name='submitted' />
				<input type='submit' class='btn btn-primary' value='Change Password' />
				
			</form>
		</div>
		<span class='makesmallbigger smallmarginfromtop label'>Password should be of length between 6-16 characters. It should have atleast one numberic and one special character.</span>
	</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="jquery.placeholder.js"></script>
<script type='text/javascript' src='commonJs.js'></script>

</body>

</html>