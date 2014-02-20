<?php
ob_start();
session_start();
unset($_SESSION['userId']);
unset($_SESSION['userEmail']);
unset($_SESSION['userRole']);
header("Location: login.php");
?>