<?php
/**
author: agupt108
Date:	17 Feb 2014
*/
include_once 'Constants.php' ;
include_once 'FileLogger.php' ;
include_once 'MySqlDBConnection.php';


class UserServices
{
	public function __construct(){
        $this->fileLogger_ = FileLogger::getInstance(get_class());
	}

    public function getPasswordUsingEmail($email){
        $dbConn = MySqlDBConnection::getInstance(APP_DB_MYSQL_USER, APP_DB_MYSQL_PASS, APP_DB_MYSQL_NAME, APP_DB_MYSQL_HOST);
        if(! $dbConn->connect())
        {
            $message = ' Failed to connect to database :  ' . APP_DB_MYSQL_NAME . ' on Host : ' . APP_DB_MYSQL_HOST . ' using User : ' . APP_DB_MYSQL_USER . ' using password: ' . APP_DB_MYSQL_PASS ;
            $this->fileLogger_->log(LogLevel::$ERROR, $message);
            return false ;
        }
        $userId = $this->getUserId($email) ;
        if($userId){
            return $this->getPassword($userId) ;
        }else{
            return false ;
        }
        return false ;
    }

    public function getPasswordUsingId($userId){
        $dbConn = MySqlDBConnection::getInstance(APP_DB_MYSQL_USER, APP_DB_MYSQL_PASS, APP_DB_MYSQL_NAME, APP_DB_MYSQL_HOST);
        if(! $dbConn->connect())
        {
            $message = ' Failed to connect to database :  ' . APP_DB_MYSQL_NAME . ' on Host : ' . APP_DB_MYSQL_HOST . ' using User : ' . APP_DB_MYSQL_USER . ' using password: ' . APP_DB_MYSQL_PASS ;
            $this->fileLogger_->log(LogLevel::$ERROR, $message);
            return false ;
        }
        $pass = false ;
        $query = "SELECT password from users where user_id='" . $userId . "'" ;
        if($rowsSelected = $dbConn->runSelectQuery($query) ){

            if($rowsSelected > 1){
                // Multi entry found for this user_id ...Something fishy
                $message = ' Multi entry found for this user_id :: ' . $userId . ' ...Something fishy ' ;
                $this->fileLogger_->log(LogLevel::$ERROR, $message);
                return $pass ;
            }

            $row = mysql_fetch_array($dbConn->getResultSet(), MYSQL_BOTH);
            $pass = $row[0] ;

        }//if
        return $pass ;
    }

    public function getUserId($email){
        $dbConn = MySqlDBConnection::getInstance(APP_DB_MYSQL_USER, APP_DB_MYSQL_PASS, APP_DB_MYSQL_NAME, APP_DB_MYSQL_HOST);
        if(! $dbConn->connect())
        {
            $message = ' Failed to connect to database :  ' . APP_DB_MYSQL_NAME . ' on Host : ' . APP_DB_MYSQL_HOST . ' using User : ' . APP_DB_MYSQL_USER . ' using password: ' . APP_DB_MYSQL_PASS ;
            $this->fileLogger_->log(LogLevel::$ERROR, $message);
            return false ;
        }
        $userId = false ;
        $query = "SELECT user_id from users where email='" . $email . "' and source='Local'" ;
        if($rowsSelected = $dbConn->runSelectQuery($query) ){

            if($rowsSelected > 1){
                // Multi entry found for this user_id ...Something fishy
                $message = ' Multi entry found for email :: ' . $email . ' and source :: Local ...Something fishy ' ;
                $this->fileLogger_->log(LogLevel::$ERROR, $message);
                return $userId ;
            }

            $row = mysql_fetch_array($dbConn->getResultSet(), MYSQL_BOTH);
            $userId = $row[0] ;

        }//if
        return $userId ;
    }

    

    public function activateAccount($userId){
        $dbConn = MySqlDBConnection::getInstance(APP_DB_MYSQL_USER, APP_DB_MYSQL_PASS, APP_DB_MYSQL_NAME, APP_DB_MYSQL_HOST);
        if(! $dbConn->connect())
        {
            $message = ' Failed to connect to database :  ' . APP_DB_MYSQL_NAME . ' on Host : ' . APP_DB_MYSQL_HOST . ' using User : ' . APP_DB_MYSQL_USER . ' using password: ' . APP_DB_MYSQL_PASS ;
            $this->fileLogger_->log(LogLevel::$ERROR, $message);
            return false ;
        }

        $query = "UPDATE users set active_status='VERIFIED' where user_id='" . $userId . "'" ;
        if($rowsEffected = $dbConn->runAlterQuery($query) ){
            //echo $rowsEffected . PHP_EL ;
            $message = ' Successfully verified the account. ' ;
            $this->fileLogger_->log(LogLevel::$DEBUG, $message);
        }else{
            $message = ' Failed to verified the account. ' ;
            $this->fileLogger_->log(LogLevel::$ERROR, $message);
            $this->regError_ = $message ;
            return false ;
        }
        return true ;
    }

    public function getOnlineUsers(){
        $dbConn = MySqlDBConnection::getInstance(APP_DB_MYSQL_USER, APP_DB_MYSQL_PASS, APP_DB_MYSQL_NAME, APP_DB_MYSQL_HOST);
        if(! $dbConn->connect())
        {
            $message = ' Failed to connect to database :  ' . APP_DB_MYSQL_NAME . ' on Host : ' . APP_DB_MYSQL_HOST . ' using User : ' . APP_DB_MYSQL_USER . ' using password: ' . APP_DB_MYSQL_PASS ;
            $this->fileLogger_->log(LogLevel::$ERROR, $message);
            return false ;
        }
        
        $onlineUsers = Array();

        // Get userids of all registered users
        $query = "SELECT user_id, email from users" ;
        if($rowsSelected = $dbConn->runSelectQuery($query) ){
            while($row = mysql_fetch_array($dbConn->getResultSet(), MYSQL_BOTH)){
                if($this->isOnline($row[0]) ){
                    $onlineUsers[$row[0]] = $row[1] ;
                }
            }//while
        }//if
        print_r($onlineUsers);
        return $onlineUsers ;
    }


	public function isOnline($userId){
		$this->fileLogger_->log(LogLevel::$DEBUG, " Going to check user live status....");
		$dbConn = MySqlDBConnection::getInstance(APP_DB_MYSQL_USER, APP_DB_MYSQL_PASS, APP_DB_MYSQL_NAME, APP_DB_MYSQL_HOST);
        if(! $dbConn->connect())
        {
            $message = ' Failed to connect to database :  ' . APP_DB_MYSQL_NAME . ' on Host : ' . APP_DB_MYSQL_HOST . ' using User : ' . APP_DB_MYSQL_USER . ' using password: ' . APP_DB_MYSQL_PASS ;
            $this->fileLogger_->log(LogLevel::$ERROR, $message);
            return false ;
        }

        $query = "SELECT lastactivitytimestamp from users_online where user_id='" . $userId . "'" ;
        if($rowsSelected = $dbConn->runSelectQuery($query) ){
        	if($rowsSelected > 1){
        		// Multi entry found for this user_id ...Something fishy
        		$message = ' Multi entry found for this user_id ...Something fishy ' ;
            	$this->fileLogger_->log(LogLevel::$ERROR, $message);
        		return false ;
        	}
        	// User entry found
        	// check timestamp
        	$row = mysql_fetch_array($dbConn->getResultSet(), MYSQL_BOTH);
        	// time() - give time in seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
        	if(time() > ( $row[0] + APP_USER_STATUS_CHECK_TIME_INTERVAL ) ){
        		// Offline
        		$message = ' User is offline for id : ' . $userId ;
        		$this->fileLogger_->log(LogLevel::$INFO, $message);
        		return false ;
        	}else{
        		// Online
        		$message = ' User is online for id : ' . $userId ;
        		$this->fileLogger_->log(LogLevel::$INFO, $message);
        	}
        }else{
        	// User entry not found
        	$message = ' User entry not found for id : ' . $userId ;
            $this->fileLogger_->log(LogLevel::$WARNING, $message);
        	return false ;
        }
        return true ;
	}

	public function updateStatus($userId){
        $this->fileLogger_->log(LogLevel::$DEBUG, " Going to update the user live status....");
		$dbConn = MySqlDBConnection::getInstance(APP_DB_MYSQL_USER, APP_DB_MYSQL_PASS, APP_DB_MYSQL_NAME, APP_DB_MYSQL_HOST);
        if(! $dbConn->connect())
        {
            $message = ' Failed to connect to database :  ' . APP_DB_MYSQL_NAME . ' on Host : ' . APP_DB_MYSQL_HOST . ' using User : ' . APP_DB_MYSQL_USER . ' using password: ' . APP_DB_MYSQL_PASS ;
            $this->fileLogger_->log(LogLevel::$ERROR, $message);
            return false ;
        }

        $query = "SELECT lastactivitytimestamp from users_online where user_id='" . $userId . "'" ;
        if($rowsSelected = $dbConn->runSelectQuery($query) ){
        	if($rowsSelected > 1){
        		// Multi entry found for this user_id ...Something fishy
        		$message = ' Multi entry found for this user_id ...Something fishy ' ;
            	$this->fileLogger_->log(LogLevel::$ERROR, $message);
        		return false ;
        	}
        	// User entry found
        	// update timestamp
        	// time() - give time in seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
        	$query = "UPDATE users_online set lastactivitytimestamp='" . time() . "' where user_id='" . $userId . "'" ;
        	if($rowsEffected = $dbConn->runAlterQuery($query) ){
                //echo $rowsEffected . PHP_EL ;
                $message = ' Successfully updated online status for user with id :: ' . $userId ;
                $this->fileLogger_->log(LogLevel::$DEBUG, $message);
            }else{
                $message = ' Failed to update online status for user with id :: ' . $userId ;
                $this->fileLogger_->log(LogLevel::$ERROR, $message);
                $this->regError_ = $message ;
                return false ;
            }
        }else{
        	// User entry not found
        	// insert it
        	$query = "INSERT INTO users_online(`user_id`, `lastactivitytimestamp`) VALUES('" . $userId . "', '" . time() . "')" ;
            if($rowsEffected = $dbConn->runAlterQuery($query) ){
                //echo $rowsEffected . PHP_EL ;
                $message = ' Successfully updated online status first time for user with id :: ' . $userId ;
                $this->fileLogger_->log(LogLevel::$DEBUG, $message);
            }else{
                $message = ' Failed to update online status first time for user with id :: ' . $userId ;
                $this->fileLogger_->log(LogLevel::$ERROR, $message);
                $this->regError_ = $message ;
                return false ;
            }
        	
        }
        return true ;
	}
}

// if($us->isOnline("ankit")){
// 	echo "Online" . PHP_EL ;
// }else{
// 	echo "Offline" . PHP_EL ;
// }

// if($us->updateStatus("ankit")){
// 	echo "Updated" . PHP_EL ;
// }else{
// 	echo "Not updated" . PHP_EL ;
// }

// if($us->isOnline("ankit")){
// 	echo "Online" . PHP_EL ;
// }else{
// 	echo "Offline" . PHP_EL ;
// }





?>