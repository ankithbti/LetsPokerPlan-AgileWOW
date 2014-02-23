<?php
/**
author: agupt108
Date:	17 Feb 2014
*/

include_once 'Constants.php' ;
include_once 'Logger.php' ;
include_once 'LogLevel.php' ;

class GenericLogger implements Logger{

	protected $loggerName_ ;
    private static $instance_ ;

	// Constructor
	private function __construct($name){
		$this->loggerName_ = $name ;
		date_default_timezone_set('UTC');
        // print "Creating " . get_class() . PHP_EL ;
	}

    public static function getInstance($name){
        if(! self::$instance_){
            self::$instance_ = new GenericLogger($name);
        }
        return self::$instance_ ;
    }

	// Destructor
	public function __destruct(){
		$this->loggerName_ = null ;
	}

	// triggered when invoking inaccessible methods in an object context.
	public function __call($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        print "Sorry this is not accessible to you. Tried calling inaccessible object method '$name' " . implode(', ', $arguments) . PHP_EL;
    }

    // triggered when invoking inaccessible methods in a static context.
    public static function __callStatic($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        print "Sorry this is not accessible to you. Tried calling inaccessible static method '$name' " . implode(', ', $arguments) . PHP_EL;
    }

    // run when writing data to inaccessible properties.
    public function __set($name, $value)
    {
        echo "Sorry this is not accessible to you. Tried setting variable :: '$name' , the value :: '$value' " . PHP_EL ;
    }

    // run when reading data from inaccessible properties.
    public function __get($name)
    {
    	echo "Sorry this is not accessible to you. Tried getting value for variable '$name'" . PHP_EL ;
    }

    // triggered by calling isset() or empty() on inaccessible properties.
    public function __isset($name)
    {
        echo "Sorry this is not accessible to you. Tried calling isset and empty for variable '$name'" . PHP_EL ;
    }

    // invoked when unset() is used on inaccessible properties.
    public function __unset($name)
    {
        echo "Sorry this is not accessible to you. Tried calling unset for variable '$name'" . PHP_EL ;
    }

    // To get the state of object itslef
    public function __toString()
    {
        $stateOfObj = " It is an logger for class :: " . $this->loggerName_ . PHP_EL ;
        return $stateOfObj ;
    }

    public function log($i, $message)
    {
    	$logMessage = " It is just a generic logger. " ;
    	return $logMessage ;
    }
}

// $trace = debug_backtrace();
        // print_r($trace);
        // trigger_error(
        //     'Undefined property via __get(): ' . $name .
        //     ' in ' . $trace[0]['file'] .
        //     ' on line ' . $trace[0]['line'],
        //     E_USER_NOTICE);
        // return null;

?>