<?php

include_once 'Constants.php';
include_once 'User.php';

ob_start();
session_start();


if(isset($_SESSION['userId']) ){
	header("Location: " . APP_USER_LOGIN_SUCCESS_URL);
}

?>

<html>

<head>
	<title>Testing Login</title>
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap.css' />
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap-responsive.css' />
	<link rel='stylesheet' type='text/css' href='commonCss.css' />

	<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2'></script>
	<script type='text/javascript' src='commonJs.js'></script>
</head>

<body>

	<div class='container topRightMenu'>
		<p class='right'><a href='register.php'>Register</a> | <a href='home.php'>Back</a></p>
	</div>

<?php

if(isset($_POST['submitted']) ){
	//echo "Form Submitted " . PHP_EL ;
	$email = $_POST['email'];
	$pass = $_POST['password'];
	//echo "Email : " . $email . " Password : " . $pass . PHP_EL ;
	$user = new User($email, $pass, "Local");
	//echo $user . PHP_EL ;
	if($user->authenticateAndFill()){
		$_SESSION['userId'] = $user->getId() ;
		$_SESSION['userEmail'] = $user->getEmail() ;
		$_SESSION['userRole'] = $user->getRole() ;
		header("Location: " . APP_USER_LOGIN_SUCCESS_URL);
	}else{
		echo "<div class='container' align='center'><span class='makebigger label label-warning'>" . $user->getAuthError() . "</span><hr></div>" ;
	}
	exit(0);
}else{
	//echo "Not submitted " . PHP_EL ;
 }

?>

	<div class='container topSection' align='center'>
		<h1>Login System</h1>
		<div class='loginWindow'>
			<form action='login.php' method='post' name='loginForm'>
				<label>
					<!-- <span>Email</span> -->
					<input id='email' type='email' name='email' placeholder='Type your Email Id' required/>
				</label>

				<label>
					<!-- <span>Password</span> -->
					<input id='password' type='password' name='password' placeholder='Type your Password' required/>
				</label>

				<br>
				<input type='hidden' name='submitted' />
				<input type='submit' class='btn btn-primary' value='Login' />
			</form>
		</div>
	</div>

</body>

</html>