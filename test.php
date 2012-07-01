<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//Do some shit
	print 'yup';
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

	/**
	 *	ACTUAL SAMPLES USING THE 'Examples of JSON Payloads' EXAMPLES (1-5) FROM APPLE'S WEBSITE.
	 *	LINK:  http://developer.apple.com/iphone/library/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/ApplePushService/ApplePushService.html#//apple_ref/doc/uid/TP40008194-CH100-SW15
	 */

	// APPLE APNS EXAMPLE 1
	$apns->newMessage(intval($_POST['id']), date('Y-m-d h:i'));
	$apns->addMessageAlert($_POST['message']);
	$badge = intval($_POST['badge']);
	if ($badge>0) {
		$aps->addMessageBadge($badge);
	}
	//$apns->addMessageCustom('acme2', array('bang', 'whiz'));
	if ($_POST['chime']) {
		$apns->addMessageSound($_POST['sound']);
	}
	$apns->queueMessage();

}
?>
<html>
<body>
<form method='post' action='/test.php'>
	Message: <input type='text' name='message' value='' /><br />
	Badge no: <input type='text' name='badge' value='' /><br />
	Custom: <input type='text' name='custom' value='' /><br />
	Sound: <br />
		bingbong<input type='radio' name='sound' value='bingbong.aiff' /><br />
		chime<input type='radio' name='sound' value='chime' /><br />
	ID: <input type='text' name='id' value='' /><br />
	<input type='submit' />
</form>
