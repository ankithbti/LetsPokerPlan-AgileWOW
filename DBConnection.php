<?php
/**
author: agupt108
Date:	17 Feb 2014
*/

include_once 'Constants.php' ;

interface DBConnection
{
	public function connect() ;
	public function disconnect() ;
	public function getHandle() ;
}