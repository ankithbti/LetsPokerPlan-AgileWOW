<?php

include_once 'Constants.php';
include_once 'User.php';
include_once 'UserServices.php';

ob_start();
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
	<title>Testing Activation</title>
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap.css' />
	<link rel='stylesheet' type='text/css' href='res/bootstrap/css/bootstrap-responsive.css' />
	<link rel='stylesheet' type='text/css' href='commonCss.css' />

</head>

<body>

	<div class='container topRightMenu'>
		<p class='right'><a href='login.php'>Login</a> | <a href='register.php'>Register</a> | <a href='home.php'>Back</a></p>
		<div class='clearFloat'></div>
	</div>

	<div class='container' align='center'>
			<?php
				if(isset($_GET['userId'])){
					$us = new UserServices();
					if($us->activateAccount($_GET['userId']) ){
						echo "<span class='makebigger label label-success'>Your account has been activated successfully. You can enjoy our services now.</span>" ;
					}else{
						echo "<span class='makebigger label label-warning'>Your account has not been activated successfully. Please contact admin.</span>" ;
					}
				}else{
					echo "<span class='makebigger label label-info'>Something Fissy going on here. Please contact admin.</span>" ;
				}
			?>
	</div>
</body>
</html>