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
	<title>Testing Login</title>
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap.css' />
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap-responsive.css' />
	<link rel='stylesheet' type='text/css' href='commonCss.css' />

</head>

<body>

	<div class='container topRightMenu'>
		<p class='right'><a href='register.php'>Register</a> | <a href='forgotPassword.php'>Forgot Password</a> | <a href='home.php'>Back</a></p>
		<div class='clearFloat'></div>
	</div>

	<div class='container' id='loginFormErrors' align='center'>
	</div>

<?php

if(isset($_POST['submitted']) ){
	//echo "Form Submitted " . PHP_EL ;
	$email = $_POST['email'];
	$pass = $_POST['mypass'];
	//echo "Email : " . $email . " Password : " . $pass . PHP_EL ;
	$user = new User($email, $pass, "Local");
	//echo $user . PHP_EL ;
	if($user->authenticateAndFill()){
		$_SESSION['userId'] = $user->getId() ;
		$_SESSION['userEmail'] = $user->getEmail() ;
		$_SESSION['userRole'] = $user->getRole() ;
		$_SESSION['activeStatus'] = $user->getActiveStatus() ;
		echo APP_USER_LOGIN_SUCCESS_URL . PHP_EL ;
		header("Location: " . APP_USER_LOGIN_SUCCESS_URL);
	}else{
		echo "<div class='container' align='center'><span class='makebigger label label-warning'>" . $user->getAuthError() . "</span><hr></div>" ;
	}
}else{
	//echo "Not submitted " . PHP_EL ;
 }

?>

	<div class='container topSection' align='center'>
		<h1>Login System</h1>
		<div class='loginWindow'>
			<form action='login.php' method='post' name='loginForm' onsubmit='return isLoginFormFilledCorrectly();'>

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
				</table>
				<br>
				<input type='hidden' name='submitted' class='hidden'/>
				<input type='submit' class='btn btn-primary' value='Login' />
			</form>
		</div>

		<span class='makesmallbigger smallmarginfromtop label'>Password should be of length between 6-16 characters. It should have atleast one numberic and one special character.</span>
	</div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="jquery.placeholder.js"></script>
<script type='text/javascript' src='commonJs.js'></script>

</body>

</html>