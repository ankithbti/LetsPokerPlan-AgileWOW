<?php
/**
author: agupt108
Date:	17 Feb 2014
*/

include_once 'Constants.php' ;
include_once 'FileLogger.php' ;
include_once 'MySqlDBConnection.php' ;

class Mailer
{
	private $logger_ ; 
	private static $mailerInstance_ ;
	private static $instanceCount_ ;

	private function __construct(){
		$this->logger_ = FileLogger::getInstance(get_class());
	}

	public function __destruct(){
		--static::$instanceCount_ ;
	}

	public static function getInstance(){
		if(! static::$mailerInstance_){
			static::$mailerInstance_ = new Mailer();
		}
		++static::$instanceCount_ ;
		return static::$mailerInstance_ ;
	}

	public function sendMail($to, $from, $subject, $body){
		$this->logger_->log(LogLevel::$DEBUG, "Trying sending mail. ");
		$headers = "MIME-Version: 1.0\r\n"
              ."Content-Type: text/html\r\n"
              ."Content-Transfer-Encoding: 8bit\r\n"
              ."From: =?UTF-8?B?". base64_encode($from) ."?= <$from>\r\n"
              ."X-Mailer: PHP/". phpversion();
        if( ! mail($to, $subject, $body, $headers, "-f $from")){
        	return false ;
        }
        $this->logger_->log(LogLevel::$INFO, "Sending mail to email :: " . $to . " for :: " . $subject);
        return true ;
	}
}

// $mail = Mailer::getInstance();
// $mail1 = Mailer::getInstance();
// $mail2 = Mailer::getInstance();

// if($mail2->sendMail("ankithbti007@gmail.com", "ankit.gupta@fitied.com", "Testing", "Hiiiii")){
// 	echo " Send successful. " . PHP_EL ;
// }else{
// 	echo " Send failed. " . PHP_EL ;
// }

?>