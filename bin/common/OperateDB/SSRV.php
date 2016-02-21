<?php
/*
 * Author: Suhail
 * date: 03-Sep-2015
 * Description: SSRV : Handles MSSQL Server Specific Functions
 * The functionality of the class depends upon the SQLSRV .DLL files and ODBC driver.
 * Required : WAMPP 32 Bit
 * .DLL Files : 32 Bit : https://msdn.microsoft.com/en-us/sqlserver/ff657782.aspx
 * ODBC Driver : https://www.microsoft.com/en-us/download/details.aspx?id=36434
 * PHP-SQLServer driver details : https://msdn.microsoft.com/en-us/library/cc296170(v=sql.105).aspx
 * php_sqlsrv_55_ts.dll : PHP5.5
 * php_sqlsrv_56_ts.dll : PHP5.6 
 */

class SSRV {
	
	private $servername,$port,$username,$password,$database;
	private $dbconnection;
	
	/* Constructor function to connect and select database.
	 *  The argument is a assoc array with possible following structure
	 *  array(
	 *  	'servername'		=>	'',
	 *  	'port'				=>	'',
	 *  	'username'			=>	'',
	 *  	'password'			=>	'',
	 *  	'database'			=>	''
	 *  );
	 *  	'servername'	=>	'mandatory' . // serverName\instanceName
	 *  	'port'			=>	'optional'
	 *  	'username'		=>	'mandatory'
	 *  	'password'		=>	'mandatory'
	 *  	'database'		=>	'mandatory. This is the database name.'
	 *
	 */
	
	function __construct($config = '') {
		
		if(!is_array($config))  {
			$config = $this->getDBConfig();
		}
		
		$this->database = $config['DatabaseName'];
		$this->password = $config['passWord'];
		$this->port = $config['Port'];
		$this->servername = $config['servername'];
		$this->username = $config['userName'];
		
		$connection_state = $this->connect();
	}
	
	function __destruct() {
		sqlsrv_close( $this->dbconnection );
		unset($this->dbconnection);
	}
	
	/**
	 * Returns MSSQL Server Configuration. Defined in 'Db.php'
	 * @return multitype:string
	 */
	private function getDBConfig() {				
		return getMSSQL_Config();
	}
	
	private function connect() {
		$connection_info = array('Database' => $this->database, 'UID' => $this->username, 'PWD' => $this->password);
		$connection_info_wa = array('Database' => $this->database);
		
		try {
			$this->dbconnection = sqlsrv_connect($this->servername, $connection_info_wa);
		}catch(Exception $e) {return false;}
		
		return true;
	}
	
	private function Prepare_Query($input_array, $prepare_For)
	{
		$Query	=	"";
		switch($prepare_For)
		{
			case 'READ':
				if($input_array['Fields'] == "" || $input_array['Fields'] == NULL || $input_array['Table']	==	"" || $input_array['Table']	==	NULL)
					return false;
	
					$Query	.=	"SELECT ";
					$Query	.=	$input_array['Fields'];
					$Query	.=	" FROM ";
					$Query	.=	$input_array['Table'];
						
					if(isset($input_array['clause']) && $input_array['clause'] != "" && $input_array['clause'] !== NULL)
					{
						$Query	.=	" WHERE ";
						$Query	.=	$input_array['clause'];
					}
						
					if(isset($input_array['order']) && $input_array['order'] != "" && $input_array['order'] !== NULL)
					{
						$Query	.=	" ORDER BY ";
						$Query	.=	$input_array['order'];
					}
					break;
			case 'INSERT':
				$vstring = ""; // Field String
				
				if(is_array($input_array)) {
					$tableName = $input_array['Table'];
					$input_array = $input_array['Fields'];
					$vstring	.=	"(" . $this->FieldValuePair_ToString($input_array,true) . ")";				
						
					// Column String
					$column_string = implode("," , array_keys($input_array)); // Get the column names
					$Query = "INSERT INTO ".$tableName." (" . $column_string . ") VALUES ".$vstring.";"; // Form Query String
				}
				break;
				
			case 'UPDATE':
				if($input_array['Fields'] == "" || $input_array['Fields'] == NULL || $input_array['Table']	==	"" || $input_array['Table']	==	NULL)
					return false;
	
					$Query	.=	"UPDATE ";
					$Query	.=	$input_array['Table'];
					$Query	.=	" SET ";
					$Query	.=	$this->FieldValuePair_ToString($input_array['Fields']);
						
					if(isset($input_array['clause']) && $input_array['clause'] != "" && $input_array['clause'] !== NULL)
					{
						$Query	.=	" WHERE ";
						$Query	.=	$input_array['clause'];
					}
					break;
			case 'DELETE':
				if($input_array['Table']	==	"" || $input_array['Table']	==	NULL)
					return false;
	
					$Query	.=	"DELETE FROM ";
					$Query	.=	$input_array['Table']."";
						
					if($input_array['clause'] != "" && $input_array['clause'] !== NULL)
					{
						$Query	.=	" WHERE ";
						$Query	.=	$input_array['clause'];
					}
					break;
			case 'INSERT_MR':
				$vstring = ""; // Field String
				
				if(is_array($input_array)) {
					$tableName = $input_array['TABLE_NAME'];
					$input_array = $input_array['FIELD_ARRAY'];
					for($i = 0 ;$i < count($input_array); $i++) {
						$vstring	.=	"(" . $this->FieldValuePair_ToString($input_array[$i],true) . ")";
						if(! ($i == (count($input_array) - 1))) $vstring .= ",";
					}
				
				
					// Column String
					$column_string = implode("," , array_keys($input_array[0])); // Get the column names
					$Query = "INSERT INTO ".$tableName." (" . $column_string . ") VALUES ".$vstring.";"; // Form Query String
				}
				
				break;
		}
		return $Query;
	}
	
	private function FieldValuePair_ToString($FieldValueArray,$onlyValueString=false) {
		$FieldsAsString	=	"";
		foreach ($FieldValueArray as $FieldName => $value) {
			if($FieldsAsString != "")
				$FieldsAsString	.=	', ';
				
			if(strpos($value,'\'') !== false || strpos($value,'\"') !== false) {
				$value	=	addslashes($value);
			}
			if($onlyValueString){
				if($value	!= 'now()')
					$FieldsAsString	.=	 "'".$value."'";
				else
					$FieldsAsString	.=	 $value;
	
			}
			else{
				if($value	!= 'now()')
					$FieldsAsString	.=	 $FieldName." = '".$value."'";
				else
					$FieldsAsString	.=	 $FieldName." = ".$value;
			}
		}
		return $FieldsAsString;
	}
	
	private function Prepare_Output($statement_resource, $output_format, $key_field_output = '')
	{
		$output_format = strtolower($output_format); // Convert output_Format to lowercase
		switch($output_format) {

			case 'num_arr':
				while($row = sqlsrv_fetch_array( $statement_resource, SQLSRV_FETCH_NUMERIC) ) {
						$output_arr[] = $row;
				}
				return $output_arr;
				break;
			
			case 'num_rows':
				return sqlsrv_num_rows( $statement_resource );
				break;
				
			case 'assoc':
			default:
				while($row = sqlsrv_fetch_array( $statement_resource, SQLSRV_FETCH_ASSOC) ) {
					if($key_field_output != '' && isset($row[$key_field_output])){
						$output_arr[strval($row[$keyField_Output])]	=	$row;
					} else {
						$output_arr[] = $row;
					}
				}
				return $output_arr;
				break;
				
		}
	}
	
	public function getDBConnection() {
		return $this->dbconnection;
	}
	
	/**
	 * 
	 * @return multitype: Returns an associative array as described in the following table: (Key -- Value )
	 * ==============================================
	 * CurrentDatabase	 The connected-to database
	 * ==============================================
		SQLServerVersion	The SQL Server version.
		SQLServerName	The name of the server.
	 */
	public function getSQLServerInfo() {
		return sqlsrv_server_info($this->dbconnection);
	}
	
	/**
	 * Returns an associative array with keys described in the table below. Returns FALSE otherwise.
	 * ==================================================
	 *  Key				Description
	 *  ==================================================
	 *	DriverDllName	SQLNCLI10.DLL
	 *	DriverODBCVer	ODBC version (xx.yy)
	 *	DriverVer	SQL Server Native Client DLL version (10.5.xxx)
	 *	ExtensionVer	php_sqlsrv.dll version (2.0.xxx.x)
	 * @return multitype:
	 */
	public function getClientInfo() {
		return sqlsrv_client_info($this->dbconnection);
	}

	public function Read($fieldValueArray = '', $DataType	=	'', $outputFormat = '') {
		return $this->transact($fieldValueArray, 'READ', $outputFormat);
	}
	
	public function Insert($fieldValueArray = '', $outputFormat = '') {
		return $this->transact($fieldValueArray, 'INSERT', $outputFormat);
	}
	
	public function Update($fieldValueArray = '', $outputFormat = '') {
		$this->transact($fieldValueArray, 'UPDATE', $outputFormat);
	}
	
	public function Delete($fieldValueArray = '', $outputFormat = '') {
		$this->transact($fieldValueArray, 'DELETE', $outputFormat);
	}
	
	public function InsertMR($multipleFieldsArray) {
		$this->transact($multipleFieldsArray, 'INSERT_MR', $outputFormat);
	}
	
	public function getNumberOfRows($query) {
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		//If a forward cursor (the default) or dynamic cursor is used, FALSE is returned.
		$result = sqlsrv_query( $this->dbconnection, $query, $params, $options );
		$rowCount = sqlsrv_num_rows( $result );
		return $rowCount;
	}

	/**
	 * Call this function to perform any of the following operation - INSERT, UPDATE, DELETE, READ
	 * @param unknown $fieldValueArray - Associative Array
	 * array(
     *				'Table'=> 'TableName',						//Mandatory
     *				'Fields'=> array(							//Mandatory
		 *				'FieldName1' =>Value1,
		 *				'FieldName2' =>Value2,
		 *				'FieldName_n'=>Value_n
	 *				)	
     *			)
     * @param unknown $operation - Type of operation : INSERT,UPDATE,DELETE,READ,INSERT_MR
     * @param unknown $outputFormat - Values possible : ASSOC | NUM_ARR | NUM_ROWS . Optional parameter
	 */

	private function transact($fieldValueArray, $operation, $outputFormat = 'ASSOC') {
		$operation = strtoupper($operation);
		$transactReturnCode = -1; // Transaction Failed
		$read = false;
		
		switch($operation) {
			case 'INSERT':
				$Query = $this->Prepare_Query($fieldValueArray, 'INSERT');
				break;
				
			case 'UPDATE':
				$Query = $this->Prepare_Query($fieldValueArray, 'UPDATE');
				break;
			case 'DELETE':
				$Query = $this->Prepare_Query($fieldValueArray, 'DELETE');
				break;
			case 'READ':
				$Query = $this->Prepare_Query($fieldValueArray, 'READ');
				$s = sqlsrv_query($this->dbconnection, $Query);
				$output = $this->Prepare_Output($s, $outputFormat);
				$transactReturnCode = $output;
				sqlsrv_free_stmt( $s);
				$read = true;
				break;
			case 'INSERT_MR':
				$tableName = $fieldValueArray['TABLE_NAME'];
				$listOfID = $fieldValueArray['ID_LIST'];
				$FieldsArray = $fieldValueArray['FIELD_DETAILS'];					
				$input_array = array('FIELD_ARRAY' => $FieldsArray, 'TABLE_NAME' => $tableName);
				$Query = $this->Prepare_Query($fieldValueArray, 'INSERT_MR');
				break;
		}
		
		
		if( (!$read) && (sqlsrv_begin_transaction( $this->dbconnection )) ) {
			$s = sqlsrv_query($this->dbconnection, $Query);
			if($s) {
				sqlsrv_commit( $this->dbconnection );
				$transactReturnCode = 0; // Transaction Success
			}
		}
		
		return $transactReturnCode;
		
	}
	
}