<?php

include_once 'Constants.php';
include_once 'User.php';

ob_start();
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
	<title>Testing Home</title>
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap.css' />
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap-responsive.css' />
	<link rel='stylesheet' type='text/css' href='commonCss.css' />

	<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2'></script>
	<script type='text/javascript' src='commonJs.js'></script>
</head>

<body>
	<div class='container'>
		<div class='topRightMenu'>
			<?php if(! isset($_SESSION['userId']) ){ ?>
			<p class='right'> <a href='login.php'>Login</a> | <a href='register.php'>Register</a> | <a href='forgotPassword.php'>Forgot Password</a></p>
			<?php }else{?>
			<p class='right'> <span class='makelittlebigger label label-success'>Welcome <?php echo $_SESSION['userEmail'] ; ?></span> | <a href='changePassword.php'>Change Password</a> | <a href='logout.php'>Logout</a></p>
			<?php } ?>
		</div>
	</div>
	<div class='container topHeader' align='center'>
		<h1>Welcome to Home of Testing System</h1>
	</div>

	<?php if( isset($_SESSION['userId']) ){ ?>
		<div class='container topHeader' align='center'>
		<?php
			if(isset($_SESSION['activeStatus']) && $_SESSION['activeStatus'] == 'VERIFIED'){
				echo "<h3>Your account is active. Enjoy!!!!</h3>";
			}else{
				echo "<h3>Your account is not active yet.</h3>
					<p>Did you click the activation link we have send you in email. If yes, please contact our support team.</p>";
			}
		?>
		</div>
	<?php } ?>

</body>

</html>