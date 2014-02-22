<?php
/**
author: agupt108
Date:	17 Feb 2014
*/

// Common Constants
define('PHP_EL', '<br>');
define('APP_LOG_LEVEL_CONF', 1);
define('APP_HASH_ALGO', 'sha1');
define('APP_LOG_FILE_CONF', 'AppLog.log');

// For Development
define('APP_DB_MYSQL_NAME', 'msgbrd');
define('APP_DB_MYSQL_USER', 'root');
define('APP_DB_MYSQL_PASS', 'saring');
// For PROD
//define('APP_DB_MYSQL_NAME', 'fitiedc1_letspokerplan');
//define('APP_DB_MYSQL_USER', 'fitiedc1_common');
//define('APP_DB_MYSQL_PASS', 'onlinejusthost007@');

define('APP_DB_MYSQL_HOST', 'localhost');
define('APP_USER_STATUS_CHECK_TIME_INTERVAL', 5);
define('APP_USER_LOGIN_SUCCESS_URL', 'home.php');
define('APP_USER_LOGIN_FAILURE_URL', 'loginFail.php');

// $trace = debug_backtrace();
        // print_r($trace);
        // trigger_error(
        //     'Undefined property via __get(): ' . $name .
        //     ' in ' . $trace[0]['file'] .
        //     ' on line ' . $trace[0]['line'],
        //     E_USER_NOTICE);
        // return null;

?>