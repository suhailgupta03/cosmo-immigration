<?php
/*
 * Author: Aditya 
 * date: 20-Oct-2014
 * Description: This is called by rackspace health chekup. So here we read some value from database and send response
 */

//Includes complete implementation of DB operations
require_once	'DbMgrInterface.php';

$readSystemSettings	=	DB_Read(array(
						'Table'	=>	'systemsettings',
						'Fields'	=>	'*',
						'Table'	=>	'systemsettings',
				), 'NUM_ROWS', ''
			);
			
echo $readSystemSettings;		

?>