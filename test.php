<?php

include_once 'BrowserLogger.php' ;
include_once 'MySqlDBConnection.php' ;
include_once 'User.php' ;

$browserLogger_ = new BrowserLogger("Test.php");

// $dbConn = new MySqlDBConnection(APP_DB_MYSQL_USER, APP_DB_MYSQL_PASS, APP_DB_MYSQL_NAME, APP_DB_MYSQL_HOST);
// if($dbConn->connect()){
// 	$browserLogger_->log(LogLevel::$DEBUG, 'Connecte to DB :: ' . APP_DB_MYSQL_HOST);
// }

// to use alter query
// $query = "INSERT INTO test VALUES('sumit')" ;
// if($rowsEffected = $dbConn->runAlterQuery($query) ){
// 	echo $rowsEffected . PHP_EL ;
// }else{
// 	echo " Failed to insert...." . PHP_EL ;
// }

// to use select query
// $query = "SELECT * from test" ;
// if($rowsSelected = $dbConn->runSelectQuery($query) ){
// 	echo $rowsSelected . PHP_EL ;
// 	while($row = mysql_fetch_array($dbConn->getResultSet(), MYSQL_BOTH) )
// 	{
// 		echo " Fetched User : " . $row[0] . ' :: ' . $row['name'] . PHP_EL ;
// 	} 
// }else{
// 	echo " Failed to select...." . PHP_EL ;
// }

$user = new User('ankithbti@gmail.com', 'saring', 'Local');
// echo hash(APP_HASH_ALGO, "saring"). PHP_EL;
// echo hash(APP_HASH_ALGO, 'ankithbti007@gmail.com' . ' ' . 'Local');
// f36bd196b6fe2abf7adaadf579783edf73692d82
// 7e197f0569f42ccc8e9b260192875be69308005d

//insert into users VALUES('7e197f0569f42ccc8e9b260192875be69308005d', 'ankithbti007@gmail.com', 'f36bd196b6fe2abf7adaadf579783edf73692d82', 'Local', 'Regular')
if($user->authenticateAndFill()){
	echo " authenticated successfully...." . PHP_EL ;
}
if($user->register()){
	echo " Registerd successfully....." . PHP_EL ;
}
echo $user ;
/*
For SELECT, SHOW, DESCRIBE, EXPLAIN and other statements returning resultset, mysql_query() returns a resource on success, or FALSE on error.

For other type of SQL statements, INSERT, UPDATE, DELETE, DROP, etc, mysql_query() returns TRUE on success or FALSE on error.

The returned result resource should be passed to mysql_fetch_array(), and other functions for dealing with result tables, to access the returned data.

Use mysql_num_rows() to find out how many rows were returned for a SELECT statement or mysql_affected_rows() to find out how many rows were affected by a DELETE, INSERT, REPLACE, or UPDATE statement.

mysql_query() will also fail and return FALSE if the user does not have permission to access the table(s) referenced by the query.
*/

?>