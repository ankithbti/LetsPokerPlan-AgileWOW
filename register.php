<?php

include_once 'Constants.php';
include_once 'User.php';

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
		<p class='right'><a href='login.php'>Login</a> | <a href='home.php'>Back</a></p>
	</div>

	<div class='container' id='registerFormErrors' align='center'>
	</div>

<?php

if(isset($_POST['submitted']) ){
	//echo "Form Submitted " . PHP_EL ;
	$email = $_POST['email'];
	$pass = $_POST['password'];
	$cpass = $_POST['cpassword'];
	if(strcmp($pass, $cpass) != 0){
		echo "<div class='container' align='center'><span class='makebigger label label-warning'>" . "Password does not match with the confirm password. Please register again." . "</span><hr></div>" ;
	}else{
		//echo "Email : " . $email . " Password : " . $pass . PHP_EL ;
		$user = new User($email, $pass, "Local");
		// //echo $user . PHP_EL ;
		if($user->register()){
			echo "<div class='container' align='center'><span class='makebigger label label-info'>
				User registered successfully. You can login now.
			</span><hr></div>" ;
			
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
				<label>
					<!-- <span>Email</span> -->
					<input id='email' type='email' value="<?php if(isset($_POST['email'])){ echo $_POST['email'] ; } ?>" name='email' placeholder='Type your Email Id' required />
					<span id='emailValidity'><img src='red_circle.png' style='width: 20px; height: 20px;'/></span>
				</label>

				<label>
					<!-- <span>Password</span> -->
					<input id='password' type='password' name='password' placeholder='Type your Password' required/>
					<span id='passwordValidity'><img src='red_circle.png' style='width: 20px; height: 20px;'/></span>
				</label>

				<label>
					<!-- <span>Confirm Password</span> -->
					<input id='cpassword' type='password' name='cpassword' placeholder='Confirm Password' required/>
					<span id='confirmPasswordValidity'><img src='red_circle.png' style='width: 20px; height: 20px;'/></span>
				</label>

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