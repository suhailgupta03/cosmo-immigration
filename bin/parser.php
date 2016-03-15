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
					'query_regarding' => $message,
					'email_user' => $emailAddress,
					'phone' => $phoneNumber,
					'full_name' => $fullName
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
						'query_regarding' => $queryRegarding,
						'phone' => $phoneNumber,
						'full_name' => $fullName
				)
		);
		$iresult = DB_Insert($insertArray);
		if($iresult)
			echo "success";
		break;
	
	case 3:
		$fullName = $_POST['firstName'] . ' '. $_POST['lastName'];
		$mobile = $_POST['mobile'];
		$email = $_POST['email'];
		$aboutY = $_POST['aboutY'];
		$insertArray = array(
				'Table' => 'user_info',
				'Fields' => array(
						'full_name' => $fullName,
						'phone_number' => $mobile,
						'username' => $email,
						'notes' => $aboutY,
						'user_type' => -1
				)
		);
		$iresult = DB_Insert($insertArray);
		if($iresult)
			echo "success";
	default:
		break;
		
}