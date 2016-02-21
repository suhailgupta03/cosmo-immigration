<?php
require_once 'Mail.php';
require_once './common/commonfunctions.php';
require_once './common/OperateDB/DbMgrInterface.php';

$param = $_POST['param'];

switch($param) {
	case '1':
		$fullName = $_POST['fullName'];
		$phoneNumber = $_POST['phoneNumber'];
		$emailAddress = $_POST['emailAddress'];
		$message = $_POST['message'];
		$mail = new CIMail();
		$mail->setPhoneNumber($phoneNumber);
		$mail->setEmailAddress($emailAddress);
		$mail->setQuery($message);
		$mail->setSubject('New Message From : '. strtoupper($fullName));
		$status = $mail->send();
		$insertArray = array(
			'Table' => 'queries_received',
			'Fields' => array(
					'query' => $message,
					'email' => $emailAddress,
					'phone' => $phoneNumber,
					'name' => $fullName
			)
		);
		$iresult = DB_Insert($insertArray);
		if($iresult)
			echo "success";
		break;
	
	case '2':
		$fullName = $_POST['fullName'];
		$phoneNumber = $_POST['phoneNumber'];
		$queryRegarding = $_POST['queryRegarding'];
		$mail = new CIMail();
		$mail->setPhoneNumber($phoneNumber);
		$mail->setEmailAddress("-NA-");
		$mail->setQuery($queryRegarding);
		$mail->setSubject("Call scheduled at: ".$phoneNumber);
		$status = $mail->send();
		$insertArray = array(
				'Table' => 'queries_received',
				'Fields' => array(
						'query' => $queryRegarding,
						'phone' => $phoneNumber,
						'name' => $fullName
				)
		);
		$iresult = DB_Insert($insertArray);
		if($iresult)
			echo "success";
		break;
	
	default:
		break;
		
}