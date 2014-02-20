<?php
/**
author: agupt108
Date:	17 Feb 2014
*/

include_once 'DBConnection.php' ;
include_once 'BrowserLogger.php' ;
include_once 'FileLogger.php' ;

class MySqlDBConnection implements DBConnection
{
	private $dbHandle_ ;
	private $dbUser_ ;
	private $dbPassword_ ;
	private $dbName_ ;
	private $dbHost_ ;
	private $fileLogger_ ;
	private $browserLogger_ ;
	private $resultSet_ ;
	private $isConnected_ ;

	public function __construct($user, $pass, $dbName, $dbHost)
	{
		$this->dbUser_ = $user ;
		$this->dbPassword_ = $pass ;
		$this->dbName_ = $dbName ;
		$this->dbHost_ = $dbHost ;
		$this->browserLogger_ = new BrowserLogger(get_class());
		$this->fileLogger_ = new FileLogger(get_class());
		$this->isConnected_ = false ;
	}

	public function __destruct()
	{
		$this->disconnect();
	}

	public function connect()
	{
		if($this->isConnected_){
			return true ;
		}
		$this->dbHandle_ = mysql_connect($this->dbHost_, $this->dbUser_, $this->dbPassword_) ;
		if (! $this->dbHandle_)
		{
			$this->fileLogger_->log(LogLevel::$ERROR, 'Could not connect to mysql database : ' . mysql_error());
			return false ;
		}
		if(! mysql_select_db($this->dbName_, $this->dbHandle_)){
			$this->fileLogger_->log(LogLevel::$ERROR, 'Could not select database: ' . $this->dbName_);
			return false ;
		}
		$this->fileLogger_->log(LogLevel::$DEBUG, 'Connected to  database : ' . $this->dbName_ . ' successfully. ');
		//$this->browserLogger_->log(LogLevel::$DEBUG, 'Connected to database : ' . $this->dbName_ . ' successfully. ');
		$this->isConnected_ = true ;
		return true ;
	}

	public function disconnect()
	{
		if( ! mysql_close($this->dbHandle_)){
			$this->fileLogger_->log(LogLevel::$ERROR, 'Failed to close database connection : ' . $this->dbName_);
			return false ;
		}else{
			$this->fileLogger_->log(LogLevel::$DEBUG, 'Successfully closed database connection : ' . $this->dbName_);
		}
		$this->isConnected_ = false ;
		return true ;
	}

	public function getHandle()
	{
		if($this->isConnected_){
			return $this->dbHandle_ ;
		}
		return false ;
	}

	// SELECT
	public function runSelectQuery($queryString)
	{
		if(! $this->isConnected_){
			$this->fileLogger_->log(LogLevel::$ERROR, 'Can not run select query as not connected to database.');
			return false ;
		}

		$this->resultSet_ = mysql_query($queryString, $this->dbHandle_);
		
		// Check result
		// This shows the actual query sent to MySQL, and the error. Useful for debugging.
		if (! $this->resultSet_) {
		    $message  = 'Invalid query: ' . mysql_error() . PHP_EL ;
		    $message .= ' Whole query: ' . $queryString ;
		    $this->fileLogger_->log(LogLevel::$ERROR, $message);
		    return false ;
		}

		$numOfRowsSelected = mysql_num_rows($this->resultSet_) ;

		if( $numOfRowsSelected == 0){
			$message  = "No rows found. ";
			$message .= ' Whole query: ' . $queryString ;
			$this->fileLogger_->log(LogLevel::$ERROR, $message);
		    return false ;
		}

		$this->fileLogger_->log(LogLevel::$DEBUG, ' Successfully run select query :: ' . $queryString ); 
		return $numOfRowsSelected ;
	}

	public function getResultSet(){
		if(! $this->isConnected_){
			$this->fileLogger_->log(LogLevel::$ERROR, 'Can not return resultset as not connected to database.');
			return false ;
		}
		return $this->resultSet_ ;
	}
 
	// INSERT, UPDATE, REPLACE or DELETE
	public function runAlterQuery($query){
		if(! $this->isConnected_){
			$this->fileLogger_->log(LogLevel::$ERROR, 'Can not run alter query not connected to database.');
			return false ;
		}

		if(! mysql_query($query, $this->dbHandle_)){
			$message  = " Alter Query failed. ";
			$message .= ' Whole query: ' . $query ;
			$this->fileLogger_->log(LogLevel::$ERROR, $message);
			return false ;
		}

		$numOfRowsUpdated = mysql_affected_rows($this->dbHandle_) ;

		if($numOfRowsUpdated == 0){
			$message  = " No row updated. ";
			$message .= ' Whole query: ' . $query ;
			$this->fileLogger_->log(LogLevel::$ERROR, $message);
			return false ;
		}
		$this->fileLogger_->log(LogLevel::$DEBUG, ' Successfully run alter query :: ' . $query );
		return $numOfRowsUpdated ;
	}
}

/*
For SELECT, SHOW, DESCRIBE, EXPLAIN and other statements returning resultset, mysql_query() returns a resource on success, or FALSE on error.

For other type of SQL statements, INSERT, UPDATE, DELETE, DROP, etc, mysql_query() returns TRUE on success or FALSE on error.

The returned result resource should be passed to mysql_fetch_array(), and other functions for dealing with result tables, to access the returned data.

Use mysql_num_rows() to find out how many rows were returned for a SELECT statement or mysql_affected_rows() to find out how many rows were affected by a DELETE, INSERT, REPLACE, or UPDATE statement.

mysql_query() will also fail and return FALSE if the user does not have permission to access the table(s) referenced by the query.
*/
/*
$result = mysql_query("SELECT id, name FROM mytable");
mysql_fetch_array($result, MYSQL_BOTH) // MYSQL_ASSOC , MYSQL_NUM
printf ("ID: %s  Name: %s", $row[0], $row["name"]);
*/

?>

