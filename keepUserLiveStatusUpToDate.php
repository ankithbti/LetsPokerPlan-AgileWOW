<?php

include_once 'Constants.php';
include_once 'User.php';
include_once 'UserServices.php' ;
include_once 'FileLogger.php' ;

ob_start();
session_start();


if(isset($_SESSION['userId']) ){
	$fileLogger = FileLogger::getInstance("KeepUserLiveStatusUpToDate.php");
	$email = $_SESSION['userEmail'] ;
	$id = $_SESSION['userId'] ;
	echo " Going to update status for user :: " . $email . PHP_EL ;
	$fileLogger->log(LogLevel::$DEBUG, " Going to update status for user :: " . $email);

	$us = new UserServices();

	if($us->updateStatus($id)){
		echo "Updated" . PHP_EL ;
		$fileLogger->log(LogLevel::$DEBUG, " Updated status for user :: " . $email);
	}else{
		echo "Not updated" . PHP_EL ;
		$fileLogger->log(LogLevel::$DEBUG, " Can not Update status for user :: " . $email);
	}

}else{
	$fileLogger = FileLogger::getInstance("KeepUserLiveStatusUpToDate.php");
	echo "User is not online....Can not update status...." . PHP_EL ;
	$fileLogger->log(LogLevel::$DEBUG, " User is not online....Can not update status.... ");
}

?>
