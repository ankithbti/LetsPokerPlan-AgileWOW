<?php

include_once 'Constants.php';
include_once 'User.php';

ob_start();
session_start();

?>

<html>

<head>
	<title>Testing Home</title>
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap.css' />
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap-responsive.css' />
	<link rel='stylesheet' type='text/css' href='commonCss.css' />

	<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2'></script>
	<script type='text/javascript' src='commonJs.js'></script>
</head>

<body>
	<div class='container topRightMenu'>
		<?php if(! isset($_SESSION['userId']) ){ ?>
		<p class='right'> <a href='login.php'>Login</a> | <a href='register.php'>Register</a></p>
		<?php }else{?>
		<p class='right'> <span class='makelittlebigger label label-success'>Welcome <?php echo $_SESSION['userEmail'] ; ?></span> | <a href='logout.php'>Logout</a></p>
		<?php } ?>
	</div>
	<div class='container topHeader' align='center'>
		<h1>Welcome to Home of Testing System</h1>
	</div>

</body>

</html>