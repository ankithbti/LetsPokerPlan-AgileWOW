<?php

include_once 'Constants.php';

class Thread
{

}

$pid = pcntl_fork();
if ($pid == -1) {
     die('could not fork');
} else if ($pid) {
     // we are the parent
	echo " Parent :: " . $pid . PHP_EL ;
     //pcntl_wait($status); //Protect against Zombie children
	pcntl_waitpid($pid);
} else {
     // we are the child
	echo "Child :: " . $pid . PHP_EL ;
}

?>