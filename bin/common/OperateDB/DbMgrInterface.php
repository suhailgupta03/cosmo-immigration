<?php
/*
 * Author: Aditya 
 * Author: Suhail
 * date: 31-jul-2014
 * Description: This module implments all database operations functionalities. 
 * Passing the query variables in defined format one can retireve/insert/update/delete the data from/into database. 
 * 
 * 
 */

//Includes complete implementation of DB operations
require_once __DIR__.'/DB.php';
require_once __DIR__.'/DbMgr.php';

$perform_Database_Operation = null; // Global variable to reuse the connection
$error_code = null; // Global variable holding the error_code for a transaction

function getDBConfig($config = ''){
	$source =	'Func';
	$type	=	'mysql';
	
	if(isset($config['source'])){
		$source =	$config['source'];
	}
	
	if( (strcasecmp("Func",$source) == 0) && (function_exists('get_DbConfig')) ) {
		$config = get_DbConfig();
	}
	
	if(isset($config['type'])){
		$type	=	$config['type'];
	}
	
	$config['dbType']		=	strtolower($type);
	$config['servername']	=	$config['host'];
	$config['Port']			=	$config['port'];
	$config['userName']		=	$config['username'];
	$config['passWord']		=	$config['password'];
	$config['DatabaseName']	=	$config['database'];
	
	return $config;
}

/**
	
	Logic: If config array is passed to this method then definitely the new handle is required.
	Else, If DBMgrHandle already exists then return the existing handle.
	Else, get the default DB config, and instantiate a new DBMgr Handle.
	
*/
function DBMgr_Handle($config	=	'') {
	global $perform_Database_Operation;
	
	$className	=	'DBMgr';
	if(is_array($config)){
	
		$config	=	getDBConfig($config);
		if(strcasecmp($config['dbType'], 'mssql') == 0){
			$className = 'SSRV';
		}
		$perform_Database_Operation	=	new $className($config);
		return $perform_Database_Operation;
	}
	
	if(isset($perform_Database_Operation))
		return $perform_Database_Operation;
	
	$config	=	getDBConfig($config);
	if(strcasecmp($config['dbType'], 'mssql') == 0){
		$className = 'SSRV';
	}
	
	if(function_exists('getclassObject'))
		$perform_Database_Operation	=	getclassObject($className, $config);
	else
		$perform_Database_Operation	=	new $className($config);
	
	return $perform_Database_Operation;
}

/*=====================================================READ==============================================================*/
/*
* @access public
* @param  associative_Array $readInput. Format is described below:
*			array(
*				'Fields'=> 'Field1, Field2, Field3',		//Mandatory
*				'Table'=> 'TableName',						//Mandatory
*				'clause'=> 'FieldName = FieldValue',		//optional
*				'order'	=> 'FieldName DESC'					//optional		
*			)
			clause refers exact/valid values as mysql query accepts.
			clause is a condition to filter output. e.g. 'FieldName = DesiredValue' would return entries where FieldName has DesiredValue value only.
			Order refers exact/valid values as mysql query accepts and is used to sort data selection. example value can be 'FieldName ASC' or 'FieldName DESC'.
* @param  string $outputFormat. Values can be one of  'RESULT, NUM_ROWS, NUM_ARR, ASSOC', where ASSOC is default value.
*		  It defines whether the read should return 'mysql result resource/ Numbers of rows in result set / Numbered array / Associative array
* @param  string $DataType.	Value can only be 'JSON' else ''. Use this to get data set returned as json.
* @param  string $keyField_Output. This can be a field name so that indexes of assoc array can be defined with value of the field passed.
*
* @return false, else 0(zero- for no corresponding entry), else output in described format. 
* If mysql error is to be accessed, it is available with a aglobal variable $DB_OperationError
 
*/
function DB_Read($readInput, $outputFormat	=	"ASSOC", $DataType	=	"", $keyField_Output = '') {
	$perform_Database_Operation	=	DBMgr_Handle();
	return	$perform_Database_Operation->Read($readInput, $outputFormat, $DataType, $keyField_Output);
}

/*=====================================================INSERT==============================================================*/
/*
* @access public
* @param  associative_Array $insertInput. Format is described below:
*			array(
*				'Table'=> 'TableName',						//Mandatory
*				'Fields'=> array(							//Mandatory
					'FieldName1' =>Value1,
					'FieldName2' =>Value2,
					'FieldName_n'=>Value_n
				)	
*			)
*			So in above associative array the element refered by key 'Fields' is itself an associative array which would specify DbField and corresponding Value to be stored
* @return  Inserted Id on success, else false on failure. If mysql error is to be accessed, it is available with a aglobal variable $DB_OperationError
*/
function DB_Insert($insertInput) {
	$perform_Database_Operation	=	DBMgr_Handle();
	return	$perform_Database_Operation->Insert($insertInput);
}

/*=====================================================UPDATE==============================================================*/
/*
* @access public
* @param  associative_Array $updateInput. Format is described below:
*			array(
*				'Table'=> 'TableName',						//Mandatory
*				'Fields'=> array(							//Mandatory
					'FieldName1' =>Value1,
					'FieldName2' =>Value2,
					'FieldName_n'=>Value_n
				),	
*				'clause'=> 'FieldName = FieldValue',		//optional
*			)
*			So in above associative array the element refered by key 'Fields' is itself an associative array which would specify DbField and corresponding Value to be stored
* @return  true on success, else false. If mysql error is to be accessed, it is available with a aglobal variable $DB_OperationError
*/
function DB_Update($updateInput) {
	$perform_Database_Operation	=	DBMgr_Handle();
	return	$perform_Database_Operation->Update($updateInput);
}

/*=====================================================DELETE==============================================================*/
/*
* @access public
* @param  associative_Array $deleteInput. Format is described below:
*			array(
*				'Table'=> 'TableName',						//Mandatory
*				'clause'=> 'FieldName = FieldValue',		//OPTIONAL. But if not specified all the data from database would be deleted
*			)
*			So in above associative array the element refered by key 'Fields' is itself an associative array which would specify DbField and corresponding Value to be stored
* @return  true on success, else false on failure. If mysql error is to be accessed, it is available with a aglobal variable $DB_OperationError
*/
function DB_Delete($deleteInput) {
	$perform_Database_Operation	=	DBMgr_Handle();
	return	$perform_Database_Operation->Delete($deleteInput);
}

/*=====================================================RUN ABSOLUTE QUERY==============================================================*/
/*
* @access public
* @param  Query as a string. Query can be of any type
* @param  string $outputFormat. Values can be one of  'RESULT, NUM_ROWS, NUM_ARR, ASSOC', where ASSOC is default value.
*		  It defines whether the read should return 'mysql result resource/ Numbers of rows in result set / Numbered array / Associative array
* @param  string $DataType.	Value can only be 'JSON' else ''. Use this to get data set returned as json.
* @param  string $keyField_Output. This can be a field name so that indexes of assoc array can be defined with value of the field passed.
*
* @return false, else 0(zero- for no corresponding entry), else output in described format. If mysql error is to be accessed, it is available with a aglobal variable $DB_OperationError
*/
function DB_Query($query, $outputFormat	=	"ASSOC", $DataType	=	"", $keyField_Output = '') {
	$perform_Database_Operation	=	DBMgr_Handle();
	return	$perform_Database_Operation->Query($query, $outputFormat, $DataType, $keyField_Output);
}

/**
 * The function makes a complete database dump of dump for selective tables, depending upon the TABLE_LIST. If TABLE_LIST is empty,
 * a complete database dump is made, else dump for selective tables is carried out.
 * @param unknown $ExportDBArray
 * $ExportDBArray = array(
				'DUMP_FILE_NAME' => 'dump.sql', // optional
				'TABLE_LIST' => array( // optional
						'Table1' => 'userinfo',
						'Table2' => 'usageinfo'
				)
		);
 * @return boolean
 */
function DB_ExportTable($ExportDBArray) {
	$perform_Database_Operation	=	DBMgr_Handle();
	return $perform_Database_Operation->Export($ExportDBArray);
}


/**
 * The function imports SQL Dump from the given file path.
 * @param unknown $ImportDBArray
 * $ImportDBArray = array(
				'COMPLETE_PATH' => __DIR__ . "\\database_dump.sql"
		);
 */
function DB_ImportTable($ImportDBArray) {
	$perform_Database_Operation	=	DBMgr_Handle();
	return $perform_Database_Operation->Import($ImportDBArray);
}

/**
 * 
 * @param unknown $multipleFieldsArray
 * $multipleFieldsArray = array(
						'TABLE_NAME' => 'userinfo',
						'ID_LIST' => true ,
						'FIELD_DETAILS' => array(
													array('Username' => 'bjam123','Password' =>md5('password123'), 'UserType' => 1),
													array('Username' => 'ppu12', 'Password' => md5('password1234'), 'UserType' => 2),
													array('Username' => 'ppu13', 'Password' => md5('password12345'), 'UserType' => 3),
													array('Username' => 'ppu14', 'Password' => md5('password123456'), 'UserType' => 4)
												)
				);
 * @return array containing the insert_id
 */
function DB_InsertMultipleRows($multipleFieldsArray) {
	$perform_Database_Operation	=	DBMgr_Handle();
	return $perform_Database_Operation->InsertMR($multipleFieldsArray);
}


/**
 * Call this function to perform MSSQL Server specific transactions
 * @param unknown $fieldValueArray
 * Format is described below:
 *			array(
 *				'Fields'=> 'Field1, Field2, Field3',		//Mandatory
 *				'Table'=> 'TableName',						//Mandatory
 *				'clause'=> 'FieldName = FieldValue',		//optional
 *				'order'	=> 'FieldName DESC'					//optional		
 *			)
			clause refers exact/valid values as mysql query accepts.
			clause is a condition to filter output. e.g. 'FieldName = DesiredValue' would return entries where FieldName has DesiredValue value only.
			Order refers exact/valid values as mysql query accepts and is used to sort data selection. example value can be 'FieldName ASC' or 'FieldName DESC'.
 * @param unknown $operationType
 * Possible Values - READ, INSERT, UPDATE, DELETE
 * @param unknown $outputFormat
 * Possible Values - ASSOC, NUM_ARR, NUM_ROWS
 */
function DB_SSRV_Transact($fieldValueArray, $operationType, $outputFormat) {
	$perform_Database_Operation	=	SSRV_Handle();
	$perform_Database_Operation->transact($fieldValueArray, $operation, $outputFormat);
}

/*=====================================================Close mysql connection or destroy mysqli object==============================================================*/
/*
* @access public
*/
function DB_Close()
{
	$perform_Database_Operation = DBMgr_Handle();
	$perform_Database_Operation->closeConnection();
	global $perform_Database_Operation;
	$perform_Database_Operation = null;
	return;
}

function lastTransID() {
	$perform_Database_Operation	=	DBMgr_Handle();
	return $perform_Database_Operation->getLastTransID();
}
?>
