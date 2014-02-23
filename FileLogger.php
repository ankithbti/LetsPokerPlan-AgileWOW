<?php
/**
author: agupt108
Date:	17 Feb 2014
*/

include_once 'GenericLogger.php' ;

class FileLogger extends GenericLogger{

    private $fileHandler_ ;
    private static $fileLoggerInstance_ ;
    private static $instanceCount_ ;

	// Constructor
	private function __construct($name){
		parent::getInstance($name);
        $logFile_ = APP_LOG_FILE_CONF ;
        $this->fileHandler_ = fopen(APP_LOG_FILE_CONF, 'a') or die('Cannot open file:  ' . APP_LOG_FILE_CONF);
		// print "Creating " . get_class() . PHP_EL ;
	}

    public static function getInstance($name){
        if( ! static::$fileLoggerInstance_){
            static::$fileLoggerInstance_ = new FileLogger($name) ;
        }
        ++static::$instanceCount_ ;
        return static::$fileLoggerInstance_ ;
    }

	// Destructor
	public function __destruct(){
		parent::__destruct();
        --static::$instanceCount_ ;
        if(static::$instanceCount_ == 0){
            fclose($this->fileHandler_);
        }
	}

    // To get the state of object itslef
    public function __toString()
    {
        $stateOfObj = " It is an File logger for class :: " . $this->loggerName_ . PHP_EL ;
        return $stateOfObj ;
    }

    public function log($i, $message)
    {
    	if($i < APP_LOG_LEVEL_CONF)
    	{
    		return null ;
    	}

    	$today = getdate();
    	$timeString = $today['year'] . "-" . $today['month'] . "-" . $today['mday'] . " " . $today['hours'] . ":" . $today['minutes'] . ":" . $today['seconds'] ;
    	
    	$level = "" ;

    	switch($i)
    	{
    		case LogLevel::$DEBUG :
    			$level = " DEBUG " ;
    			break;
    		case LogLevel::$INFO :
    			$level = " INFO " ;
    			break ;
    		case LogLevel::$WARNING :
    			$level = " WARNING " ;
    			break ;
    		case LogLevel::$ERROR :
    			$level = " ERROR " ;
    			break ;
    		default :
    			$level = " UNKNOWN " ;
    			break ;
    	}

    	$logMessage = $timeString . " :: " . $level . " - " . $this->loggerName_ . " :: " . $message . "\n" ;
        fwrite($this->fileHandler_, $logMessage);
    }
}



?>