<?php
/**
author: agupt108
Date:	17 Feb 2014
*/

include_once 'constants.php' ;
include_once 'BrowserLogger.php' ;
include_once 'FileLogger.php' ;
include_once 'MySqlDBConnection.php' ;

class User
{
	private $fileLogger_ ;
    private $browserLogger_ ;
    private $email_ ;
    private $hashedPassword_ ;
    private $source_ ;
    private $userId_ ;
    private $role_ ;
    private $authError_ ;
    private $regError_ ;

	public function __construct($email, $passwordStr, $source){
        $this->email_ = $email ;
        $this->hashedPassword_ = hash(APP_HASH_ALGO, $passwordStr, false);
        $this->source_ = $source ;
        $this->userId_ = hash(APP_HASH_ALGO, $this->email_ . ' ' . $this->source_, false);
		$this->browserLogger_ = new BrowserLogger(get_class());
        $this->fileLogger_ = new FileLogger(get_class());
	}

	public function __destruct(){
		unset($this->userId_) ;
        unset($this->email_) ;
        unset($this->hashedPassword_) ;
        unset($this->source_);
        unset($this->authError_);
	}

    public function getId(){
        return $this->userId_ ;
    }

    public function getEmail(){
        return $this->email_ ;
    }

    public function getSource(){
        return $this->source_ ;
    }

    public function getRole(){
        return $this->role_ ;
    }

    public function authenticateAndFill(){
        // Check here for the user entry in database
        $dbConn = new MySqlDBConnection(APP_DB_MYSQL_USER, APP_DB_MYSQL_PASS, APP_DB_MYSQL_NAME, APP_DB_MYSQL_HOST);
        if(! $dbConn->connect())
        {
            $message = ' Failed to connect to database :  ' . APP_DB_MYSQL_NAME . ' on Host : ' . APP_DB_MYSQL_HOST . ' using User : ' . APP_DB_MYSQL_USER . ' using password: ' . APP_DB_MYSQL_PASS ;
            $this->fileLogger_->log(LogLevel::$ERROR, $message);
            return false ;
        }

        //Connect success
        $query = "SELECT * from users where user_id = '" . $this->userId_ . "'" ;
        if($rowsSelected = $dbConn->runSelectQuery($query) )
        {
            echo $rowsSelected . PHP_EL ;
            // Now match password
            while($row = mysql_fetch_array($dbConn->getResultSet(), MYSQL_BOTH) )
            {
                if(strcmp($this->hashedPassword_,  $row['password']) == 0 )
                {
                    // Match
                    // fill other fileds
                    $this->role_ = $row['role'] ;
                }
                else
                {
                    // Not Match
                    $message = ' Wrong password provided for User with email :: ' . $this->email_  ;
                    $this->fileLogger_->log(LogLevel::$ERROR, $message);
                    $this->authError_ = $message ;
                    return false ;
                }
            }
        }
        else
        {
            $message = ' User with email :: ' . $this->email_ . ' is not registered with us. ' ;
            $this->fileLogger_->log(LogLevel::$ERROR, $message);
            $this->authError_ = $message ;
            return false ;
        }
        $this->fileLogger_->log(LogLevel::$INFO, " User with email : " . $this->email_ . " authenticated successfully. ");
        return true ;
    }

    public function register(){

        $dbConn = new MySqlDBConnection(APP_DB_MYSQL_USER, APP_DB_MYSQL_PASS, APP_DB_MYSQL_NAME, APP_DB_MYSQL_HOST);
        if(! $dbConn->connect())
        {
            $message = ' Failed to connect to database :  ' . APP_DB_MYSQL_NAME . ' on Host : ' . APP_DB_MYSQL_HOST . ' using User : ' . APP_DB_MYSQL_USER . ' using password: ' . APP_DB_MYSQL_PASS ;
            $this->fileLogger_->log(LogLevel::$ERROR, $message);
            return false ;
        }

        // Check is the same user already exists or not
        $query = "SELECT * from users where user_id = '" . $this->userId_ . "'" ;
        if($rowsSelected = $dbConn->runSelectQuery($query) )
        {
            // Already exist
            $message = ' User with email :: ' . $this->email_ . ' is already registerd with us.' ;
            $this->fileLogger_->log(LogLevel::$ERROR, $message);
            $this->regError_ = $message ;
            return false ;
        }
        else
        {
            $query = "INSERT INTO users(`user_id`, `email`, `password`, `source`) VALUES('" . $this->userId_ . "', '" . $this->email_ . "', '" . 
                $this->hashedPassword_ . "', '" . $this->source_ . "')" ;
            if($rowsEffected = $dbConn->runAlterQuery($query) ){
                echo $rowsEffected . PHP_EL ;
            }else{
                $message = ' Failed to register User with email :: ' . $this->email_ . ' Please try after some time. ' ;
                $this->fileLogger_->log(LogLevel::$ERROR, $message);
                $this->regError_ = $message ;
                return false ;
            }

        }
        $this->fileLogger_->log(LogLevel::$INFO, " User with email : " . $this->email_ . " registered successfully. ");
        return true ;
    }

    public function getAuthError(){
        return $this->authError_ ;
    }

    public function getRegError(){
        return $this->regError_ ;
    }

	public function __call($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        $this->fileLogger_->log(LogLevel::$WARNING, "Sorry this is not accessible to you. Tried calling inaccessible object method '$name' " . implode(', ', $arguments));
    }

    public static function __callStatic($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        $this->fileLogger_->log(LogLevel::$WARNING, "Sorry this is not accessible to you. Tried calling inaccessible static method '$name' " . implode(', ', $arguments));
    }

    public function __set($name, $value)
    {
        $this->fileLogger_->log(LogLevel::$WARNING, "Sorry this is not accessible to you. Setting '$name' to '$value' ") ;
    }

    public function __get($name)
    {
    	$this->fileLogger_->log(LogLevel::$WARNING, "Sorry this is not accessible to you. Tried getting value for variable '$name'");
    }

    // triggered by calling isset() or empty() on inaccessible properties.
    public function __isset($name)
    {
        $this->fileLogger_->log(LogLevel::$WARNING, "Sorry this is not accessible to you. Tried calling isset and empty for variable '$name'");
    }

    // invoked when unset() is used on inaccessible properties.
    public function __unset($name)
    {
        $this->fileLogger_->log(LogLevel::$WARNING, "Sorry this is not accessible to you. Tried calling unset for variable '$name'");
    }

    public function __toString()
    {
        $stateOfObj = "Email: " . $this->email_ . ' Source :: ' . $this->source_ . ' Role :: ' . $this->role_ . PHP_EL ;
        $this->fileLogger_->log(LogLevel::$DEBUG, $stateOfObj);
        return $stateOfObj ;
    }

}

// $globalLoogger = new FileLogger("Global.User");
// $globalLoogger->log(LogLevel::$ERROR, "Helloooooo");
// $globalLoogger->log(LogLevel::$DEBUG, "Helloooooo");
// $globalLoogger->log(LogLevel::$INFO, "Helloooooo");
//string hash ( string $algo , string $data [, bool $raw_output = false ] ) APP_HASH_ALGO
// hash(APP_HASH_ALGO, "data", flase);

?>