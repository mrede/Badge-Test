<?php

//Do some shit
	// AUTOLOAD CLASS OBJECTS... YOU CAN USE INCLUDES IF YOU PREFER
	if(!function_exists("__autoload")){ 
		function __autoload($class_name){
			require_once('classes/class_'.$class_name.'.php');
		}
	}

	// CREATE DATABASE OBJECT ( MAKE SURE TO CHANGE LOGIN INFO IN CLASS FILE )
	$db = new DbConnect('localhost', 'badgetest', 'badgetestRANK', 'badgetest');
	$db->show_errors();

	// FETCH $_GET OR CRON ARGUMENTS TO AUTOMATE TASKS
	$apns = new APNS($db);

	$apns->processQueue();