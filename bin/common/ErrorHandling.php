<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: Name is self explanatory
*/
function ErrorLogging($message) {
	if(isset($_SESSION['SETUP_ROOT'])){
		$filename	=	$_SESSION['SETUP_ROOT'].'/temp/Errors.txt';
	}
	else if(function_exists('getSetupRoot')){
		$filename	=	getSetupRoot().'temp/Errors.txt';
	}
	else {
		$filename	=	__DIR__.'./../../temp/Errors.txt';
	}
	
	if(!file_exists($filename))
		file_put_contents($filename, "\n");
		
	file_put_contents($filename, date("M-j-Y/H:i:s").' --- '." -- ".' Client IP: '.$_SERVER['REMOTE_ADDR'].' -- Error: '.$message."\r\n" , FILE_APPEND);
}
?>